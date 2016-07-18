import {Component, ViewChild, ElementRef} from "angular2/core";
import {RouteParams, ROUTER_DIRECTIVES} from "angular2/router";

import {ProfileIMService} from "../../../service/ProfileIMService";
import {ProfileIMChatHistory} from "../ProfileIMChatHistory/index";
import {ProfileIMTextarea} from "../ProfileIMTextarea/index";
import {LoadingLinearIndicator} from "../../../../form/component/LoadingLinearIndicator/index";
import {ProfileIMAttachments} from "../ProfileIMAttachments/index";
import {AuthService} from "../../../../auth/service/AuthService";
import {MessagesSourceType} from "../../../definitions/paths/messages";

@Component({
    selector: 'cass-profile-im-messages',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
        ProfileIMTextarea,
        ProfileIMChatHistory,
        ProfileIMAttachments,
        LoadingLinearIndicator
    ]
})

export class ProfileIMChat
{
    @ViewChild('content') content:ElementRef;
    isNeedScroll = false;
    isLoading = true;

    constructor(private params: RouteParams, private im:ProfileIMService, authService:AuthService) {
        im.loadHistory(
            authService.getCurrentAccount().getCurrentProfile().getId(),
            
            MessagesSourceType.Profile,
            parseInt(params.get('id')),
            {criteria: {seek: {
                offset: 0,
                limit: 10
            }}}
        )
            .subscribe(() => {
                this.isNeedScroll = true;
                this.isLoading = false;
            });
        
        im.createStream()
            .subscribe(() => this.isNeedScroll = true);
    }
    
    ngAfterViewChecked() {
        if(this.isNeedScroll) this.scroll();
    }
    
    scroll() {
        this.isNeedScroll = false;
        this.content.nativeElement.scrollTop = this.content.nativeElement.scrollHeight;
    }
}
