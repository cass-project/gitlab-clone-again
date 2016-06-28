import {Component} from "angular2/core";

import {ProfileModal} from "./component/ProfileModal/index";
import {ModalComponent} from "../modal/component/index";
import {ProfileSwitcher} from "./component/ProfileSwitcher/index";
import {ProfileSetup} from "./component/ProfileSetup/index";
import {ModalBoxComponent} from "../modal/component/box/index";
import {ModalControl} from "../util/classes/ModalControl";
import {AuthService} from "../auth/service/AuthService";
import {Profile} from "./definitions/entity/Profile";

@Component({
    selector: 'cass-profile',
    template: require('./template.jade'),
    directives: [
        ModalComponent,
        ModalBoxComponent,
        ProfileModal,
        ProfileSwitcher,
        ProfileSetup
    ]
})
export class ProfileComponent
{
    public modals: {
        setup: ModalControl,
        settings: ModalControl,
        switcher: ModalControl,
    } = {
        setup: new ModalControl(),
        settings: new ModalControl(),
        switcher: new ModalControl(),
    };
    
    constructor(private authService: AuthService) {}

    isSetupRequired() {
        if(this.authService.isSignedIn()) {
            return ! this.authService.getAuthToken().getCurrentProfile().entity.profile.is_initialized;
        }else{
            return false;
        }
    }
    
    getCurrentProfile(): Profile {
        return this.authService.getAuthToken().getCurrentProfile();
    }
}