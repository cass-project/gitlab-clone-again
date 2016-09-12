import {Component, Input, ViewChild, ElementRef, Directive} from "@angular/core";

import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";
import {ImageAttachmentMetadata} from "../../../definitions/entity/metadata/ImageAttachmentMetadata";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})
@Directive({selector: 'cass-post-attachment-link-image'})

export class PostAttachmentLinkImage
{
    @Input('attachment') attachment: PostAttachmentEntity<ImageAttachmentMetadata>;

    getImageURL(): string {
        return this.attachment.link.url;
    }
}