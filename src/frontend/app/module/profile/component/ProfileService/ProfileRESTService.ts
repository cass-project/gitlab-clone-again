var xmlRequest = new XMLHttpRequest();

import {Injectable} from 'angular2/core';
import {Http, URLSearchParams} from 'angular2/http';
import {AuthService} from "../../../auth/service/AuthService";
import {AvatarCropperService} from "../../../util/component/AvatarCropper/service";

@Injectable()
export class ProfileRESTService
{
    constructor(public http: Http, private avatarCropperService: AvatarCropperService){}

    public tryNumber: number = 0;
    public progressBar: number;
    public changePasswordStn = {old_password: '', new_password: '', repeat_password: ''};

    requestAccountDeleteCancel(){
        let url = `/backend/api/protected/account/cancel-request-delete`;

        return this.http.delete(url);
    }

    requestAccountDelete(){
        let url = `/backend/api/protected/account/request-delete`;

        return this.http.put(url, JSON.stringify(''));
    }

    changePassword(){
        let url = `/backend/api/protected/account/change-password`;

        return this.http.post(url, JSON.stringify({
            old_password: this.changePasswordStn.old_password,
            new_password: this.changePasswordStn.new_password
        }));
    }

    avatarUpload() {
        let crop = this.avatarCropperService.crop;

        this.tryNumber++;
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/image-upload/crop-start/${crop.start.x}/${crop.start.y}/crop-end/${crop.end.x}/${crop.end.y}`;
        let formData = new FormData();
        formData.append("file", this.avatarCropperService.file);

        xmlRequest.open("POST", url);
        xmlRequest.upload.onprogress = (e) => {
            if (e.lengthComputable) {
                this.progressBar  = Math.floor((e.loaded / e.total) * 100);
            }
        };

        xmlRequest.send(formData);

        xmlRequest.onreadystatechange = () => {
            if (xmlRequest.readyState === 4) {
                if (xmlRequest.status === 200) {
                    //this.avatarCropperService.isAvatarFormVisibleFlag = false;
                    AuthService.getAuthToken().getCurrentProfile().entity.image.public_path = JSON.parse(xmlRequest.responseText).public_path;
                    this.progressBar = 0;
                    this.tryNumber = 0;
                } else {
                    this.avatarUpload();
                }
            }
        }
    }
}