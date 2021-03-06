import {Component, Input, Output, EventEmitter, OnChanges} from "@angular/core";

import {WebmAttachmentMetadata} from "../../../../../definitions/entity/metadata/WebmAttachmentMetadata";
import {AttachmentEntity} from "../../../../../definitions/entity/AttachmentEntity";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentWebmHelper} from "../../helper";

@Component({
    selector: 'cass-attachment-webm-grid',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class AttachmentWebmGrid implements OnChanges
{
    @Input('attachment') attachment: AttachmentEntity<WebmAttachmentMetadata>;
    @Output('open') openEvent: EventEmitter<AttachmentEntity<WebmAttachmentMetadata>> = new EventEmitter<AttachmentEntity<WebmAttachmentMetadata>>();

    private viewMode: ViewOptionValue = ViewOptionValue.Grid;
    private helper: AttachmentWebmHelper;

    ngOnChanges() {
        this.helper = new AttachmentWebmHelper(this.attachment);
    }

    open(attachment: AttachmentEntity<WebmAttachmentMetadata>): boolean {
        this.openEvent.emit(attachment);

        return false;
    }
}