import {Component, OnChanges, Input, Output, EventEmitter} from "@angular/core";

import {AttachmentEntity} from "../../../../../definitions/entity/AttachmentEntity";
import {AttachmentYoutubeHelper} from "../../helper";
import {YoutubeAttachmentMetadata} from "../../../../../definitions/entity/metadata/YoutubeAttachmentMetadata";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";

@Component({
    selector: 'cass-attachment-youtube-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class AttachmentYouTubeList implements OnChanges
{
    @Input('attachment') attachment: AttachmentEntity<YoutubeAttachmentMetadata>;
    @Input('viewMode') viewMode: ViewOptionValue = ViewOptionValue.List;
    @Output('open') openEvent: EventEmitter<AttachmentEntity<YoutubeAttachmentMetadata>> = new EventEmitter<AttachmentEntity<YoutubeAttachmentMetadata>>();

    private helper: AttachmentYoutubeHelper;

    ngOnChanges() {
        this.helper = new AttachmentYoutubeHelper(this.attachment);
    }

    open(attachment: AttachmentEntity<YoutubeAttachmentMetadata>): boolean {
        this.openEvent.emit(attachment);

        return false;
    }
}