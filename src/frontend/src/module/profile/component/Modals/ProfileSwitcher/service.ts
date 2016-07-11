import {Injectable} from "angular2/core";

import {ProfileRESTService} from "../../../service/ProfileRESTService";
import {CurrentProfileService} from "../../../service/CurrentProfileService";
import {CurrentAccountService} from "../../../../account/service/CurrentAccountService";

@Injectable()
export class ProfileSwitcherService
{
    constructor(
        private profileRESTService: ProfileRESTService,
        private currentProfileService: CurrentProfileService,
        private currentAccountService: CurrentAccountService
    ) {}

    disableClick = false;

    switchProfile(profileId){
        if(!this.disableClick && this.currentProfileService.get().getId() !== profileId) {
            this.disableClick = true;

            this.currentProfileService.get().entity.profile.is_current = false;

            for (let i = 0; i < this.currentAccountService.get().profiles.profiles.length; i++) {
                if (profileId === this.currentAccountService.get().profiles.profiles[i].entity.profile.id) {
                    this.currentAccountService.get().profiles.profiles[i].entity.profile.is_current = true;
                }
            }

            this.profileRESTService.switchProfile(profileId).subscribe(data => {
                window.location.reload();
            });
        }
    }

    getProfiles(){
        return this.currentAccountService.get().profiles.profiles;
    }
}