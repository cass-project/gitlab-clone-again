import {Component} from "@angular/core";

import {ProfileModals} from "../Profile/modals";

@Component({
    selector: 'cass-profile-interests-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileInterestsCard
{
    constructor(private modals: ProfileModals) {}

    openInterestsModal() {
        this.modals.interests.open();
    }
}