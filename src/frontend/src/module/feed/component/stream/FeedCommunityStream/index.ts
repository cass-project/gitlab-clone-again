import {Component, ViewChild, ElementRef, Directive} from "@angular/core";

import {LoadingIndicator} from "../../../../form/component/LoadingIndicator/index";
import {FeedService} from "../../../service/FeedService/index";
import {CommunityCard} from "../../../../community/component/Elements/CommunityCard/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {FeedScrollDetector} from "../../FeedScrollDetector/index";
import {CommunityIndexedEntity} from "../../../../community/definitions/entity/Community";
import {AppService} from "../../../../../app/frontend-app/service";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-feed-community-stream'})

export class FeedCommunityStream
{
    constructor(
        private feed: FeedService<CommunityIndexedEntity>,
        private options: FeedOptionsService,
        private appService: AppService
    ) {}

    getViewOption() {
        return this.options.view.current;
    }

    hasStream() {
        if(!this.feed.isLoading()){
            this.appService.onScroll(true);
        }
        return typeof this.feed.stream === "object";
    }
}