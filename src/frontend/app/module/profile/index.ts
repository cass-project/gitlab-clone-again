import {Component} from "angular2/core";

import {ProfileComponentService} from "./service";
import {ProfileModal} from "./component/ProfileModal/index";
import {ModalComponent} from "../modal/component/index";
import {ProfileSwitcher} from "./component/ProfileSwitcher/index";
import {ProfileSetup} from "./component/ProfileSetup/index";
import {AuthService} from "../auth/service/AuthService";
import {Profile} from "./entity/Profile";
import {ModalBoxComponent} from "../modal/component/box/index";
import {CollectionCreateMaster} from "../collection/component/CollectionCreateMaster/index";



@Component({
    selector: 'cass-profile',
    template: require('./template.html'),
    directives: [
        ModalComponent,
        ModalBoxComponent,
        ProfileModal,
        ProfileSwitcher,
        ProfileSetup,
        CollectionCreateMaster
    ]
})
export class ProfileComponent
{
    currentProfile;
    for_id;

    constructor(private service: ProfileComponentService) {
        if(AuthService.isSignedIn()) {
            this.currentProfile = JSON.parse(JSON.stringify(AuthService.getAuthToken().getCurrentProfile().entity));
            this.for_id = '123';
        }
    }
}