import {Component, Directive} from "@angular/core";
import {ProfileModals} from "../../../modals";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-profile-interests-card'})

export class ProfileInterestsCard
{
    constructor(private modals: ProfileModals) {}

    openInterestsModal() {
        this.modals.interests.open();
    }
}