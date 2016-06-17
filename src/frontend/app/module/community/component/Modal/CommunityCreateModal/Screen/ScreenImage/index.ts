import {Component} from "angular2/core";

import {Screen} from "../../screen";
import {ImageCropperService, ImageCropper} from "../../../../../../util/component/ImageCropper/index";
import {CommunityCreateModalModel} from "../../model";
import {CommunityCreateModalForm} from "../../Form/index";

@Component({
    selector: 'cass-community-create-modal-screen-image',
    template: require('./template.jade'),
    providers: [
        ImageCropperService
    ],
    directives: [
        ImageCropper,
        CommunityCreateModalForm
    ]
})
export class ScreenImage extends Screen
{

    constructor(public cropper: ImageCropperService, protected model: CommunityCreateModalModel) {
        super();
    }

    onFileChange($event) {
        this.cropper.reset();
        setTimeout(()=>{
            this.model.uploadImage = $event.target.files[0];
            this.cropper.setFile(this.model.uploadImage);
        },0)
    }

    next() {
        if(this.cropper.hasCropper()) {
            this.model.uploadImageCrop = {
                x: this.cropper.getX(),
                y: this.cropper.getY(),
                width: this.cropper.getWidth(),
                height: this.cropper.getHeight()
            };
        }
        this.nextEvent.emit(this);
    }
}