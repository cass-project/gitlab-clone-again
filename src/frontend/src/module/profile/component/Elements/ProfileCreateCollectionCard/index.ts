import {Component} from "angular2/core";
import {ProfileModals} from "../../../modals";

@Component({
    selector: 'cass-profile-create-collection-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileCreateCollectionCard
{
    constructor(private modals: ProfileModals) {}

    openProfileSettings() {
        this.modals.settings.open();
    }
}