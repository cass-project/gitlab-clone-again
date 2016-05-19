import {Component, EventEmitter, Output} from "angular2/core";

import {EventEmitter} from "angular2/core";
import {CommunityRESTService} from "../../../service/CommunityRESTService";
import {ModalComponent} from "../../../../modal/component/index";

enum CreateStage {
    General = <any>"General",
    Theme = <any>"Theme",
    Image = <any>"Image",
    Features = <any>"Features",
    Processing = <any>"Processing",
    Complete = <any>"Complete"
}

@Component({
    selector: 'cass-community-create-modal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent
    ]
})
export class CommunityCreateModal
{
    @Output('close') close = new EventEmitter<CommunityCreateModal>();

    constructor(private service: CommunityRESTService) {}

    close() {
        this.close.emit(this);
    }
}