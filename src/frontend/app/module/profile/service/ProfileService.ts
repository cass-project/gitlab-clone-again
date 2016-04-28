var xmlRequest = new XMLHttpRequest();

import {ResponseInterface} from '../../../module/common/ResponseInterface.ts';
import {Http, Response} from 'angular2/http';
import {Observable} from 'rxjs/Observable';
import {Injectable} from 'angular2/core';
import {URLSearchParams} from 'angular2/http';
import {Headers} from "angular2/http";
import {RequestOptions} from "angular2/http";
import {AvatarCropperService} from "../component/AvatarCropper/service";
import {AuthService} from "../../auth/service/AuthService";

@Injectable()
export class ProfileService {
    constructor(public http:Http,
                public avatarCropperService:AvatarCropperService
    ){}


    progress = '0';

    public profileInfo: ProfileInfo = new ProfileInfo();

    getProfileInfo() {
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/get`;

        return this.http.post(url, JSON.stringify({}));
    }

    greetingsAsFL() {
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;
        let url = `backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/greetings-as/fl/`;

        return this.http.post(url, JSON.stringify({
            first_name: greetings.first_name,
            last_name: greetings.last_name
        }));
    }

    greetingsAsFLM() {
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;
        let url =`backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/greetings-as/lfm/`;

        return this.http.post(url, JSON.stringify({
            last_name: greetings.last_name,
            first_name: greetings.first_name,
            middle_name: greetings.middle_name
        }));
    }

    static checkInitProfile(){
       return AuthService.getAuthToken().getCurrentProfile().entity.is_initialized;
    }

    greetingsAsN() {
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;
        let url = `backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/greetings-as/n/`;

        return this.http.post(url, JSON.stringify({
            nickname: greetings.nickname
        }));
    }

    progressFunction(evt) {
        if (evt.lengthComputable) {
            this.progress = Math.round(evt.loaded / evt.total * 100) + "%";
        }
    }

        avatarUpload(file:Blob, crop:Crop) {
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/image-upload/crop-start/${crop.start.x}/${crop.start.y}/crop-end/${crop.end.x}/${crop.end.y}`;
        let formData = new FormData();
        formData.append("file", file);

        xmlRequest.open("POST", url);
        xmlRequest.send(formData);
        xmlRequest.upload.addEventListener("progress", this.progressFunction, false);

        xmlRequest.onreadystatechange = () => {
            if (xmlRequest.readyState === 4) {
                if (xmlRequest.status === 200) {
                    this.avatarCropperService.isAvatarFormVisibleFlag = false;
                    AuthService.getAuthToken().getCurrentProfile().entity.image.public_path = JSON.parse(xmlRequest.responseText).public_path;
                }
            }
        }
    }
}

export class ProfileInfo
{
    greetings_method: string;
    nickname: string;
    firstname: string;
    lastname: string;
    middlename: string;
    sex: string;
    birthday: string;
}

export interface Crop
{
    start: {
        x: number;
        y: number;
    },
    end: {
        x: number;
        y: number;
    }
}