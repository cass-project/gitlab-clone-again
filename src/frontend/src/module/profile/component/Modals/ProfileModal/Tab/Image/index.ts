import {Component, Injectable, Directive} from "@angular/core";

import {ProfileImage} from "../../../../Elements/ProfileImage/index";
import {ModalControl} from "../../../../../../common/classes/ModalControl";
import {UploadProfileImageStrategy} from "../../../../../common/UploadProfileImageStrategy";
import {ProfileRESTService} from "../../../../../service/ProfileRESTService";
import {AuthService} from "../../../../../../auth/service/AuthService";
import {UploadImageModal} from "../../../../../../form/component/UploadImage/index";
import {UploadImageService} from "../../../../../../form/component/UploadImage/service";
import {AuthToken} from "../../../../../../auth/service/AuthToken";
import {Session} from "../../../../../../session/Session";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        UploadImageService,
    ]
})
@Directive({selector: 'cass-profile-modal-tab-image'})


@Injectable()
export class ImageTab
{
    upload: UploadImageModalControl = new UploadImageModalControl();
    private deleteProcessVisible = false;

    constructor(
        private uploadImageService: UploadImageService, 
        private profileRESTService: ProfileRESTService,
        private authService: AuthService,
        private authToken: AuthToken,
        private session: Session
    ) {
        uploadImageService.setUploadStrategy(new UploadProfileImageStrategy(
            session.getCurrentProfile().entity.profile,
            authToken.getAPIKey()
        ));
    }

    getImageProfile(){
        if(this.authService.isSignedIn()){
            return this.session.getCurrentProfile().entity.profile.image.variants['512'].public_path;
        }
    }

    avatarDeletingProcess(){
        this.deleteProcessVisible = true;
        let profileId = this.session.getCurrentProfile().entity.profile.id;
        
        this.profileRESTService.deleteAvatar(profileId).subscribe(response => {
            this.session.getCurrentProfile().entity.profile.image = response.image;
            this.deleteProcessVisible = false;
        });
    }



    uploadProfileImage() {
        this.upload.open();
    }

    closeUploadProfileImageModal() {
        this.upload.close();
    }
}

class UploadImageModalControl extends ModalControl {}