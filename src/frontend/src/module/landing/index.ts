import {Component} from "angular2/core";
import {AuthComponent} from "../auth/component/Auth/index";
import {ProfileSetup} from "../profile/component/ProfileSetup/index";
import {ThemeSelect} from "../theme/component/ThemeSelect/index";
import {ProfileComponentService} from "../profile/service";
import {AuthService} from "../auth/service/AuthService";
import {MessageBusService} from "../message/service/MessageBusService/index";
import {ModalBoxComponent} from "../modal/component/box/index";
import {ModalComponent} from "../modal/component/index";
import {CollectionCreateMaster} from "../collection/component/CollectionCreateMaster/index";

@Component({
    template: require('./template.html'),
    directives: [
        AuthComponent,
        ProfileSetup,
        ThemeSelect,
        CollectionCreateMaster
    ],
})
export class LandingComponent
{
    constructor(private pService: ProfileComponentService, private auth: AuthService, private messageBusService: MessageBusService) {
    }
}