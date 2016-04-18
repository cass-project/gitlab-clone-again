import {Component, Injectable} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {ProfileService} from "../../../service/ProfileService";
import {AvatarCropper} from "../../AvatarCropper/index";
import {CORE_DIRECTIVES} from "angular2/common";
import {AuthService} from "../../../../auth/service/AuthService";
import {ProfileWelcomeInfo} from "../../../service/ProfileService";
import {Profile} from "../../../entity/Profile";
import {AvatarCropperService} from "../../AvatarCropper/service";

declare var Cropper;

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ],
    'providers': [
        ProfileService,
        AvatarCropperService,
        AuthService
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CORE_DIRECTIVES,
        AvatarCropper
    ]
})


@Injectable()
export class AccountWelcomeHome {
    constructor (private profileService: ProfileService,
                 public router: Router,
                 public avatarCropperService: AvatarCropperService,
                 public authService: AuthService
    ){}

    profileInfo: ProfileWelcomeInfo = new ProfileWelcomeInfo();

    chooseType: boolean = true;
    chooseFL: boolean = false;
    chooseLFM: boolean = false;
    chooseN: boolean = false;


    showAvatarCropper() {
        this.avatarCropperService.isAvatarFormVisibleFlag = true;
    }

    isAvatarFormVisible() {
        return this.avatarCropperService.isAvatarFormVisibleFlag;
    }

    reset(){
        this.router.parent.navigate(['Dashboard']);
        this.router.parent.navigate(['Welcome']);
    }


    ngSubmit(){
        this.router.navigate(['Profile']);
    }
}

