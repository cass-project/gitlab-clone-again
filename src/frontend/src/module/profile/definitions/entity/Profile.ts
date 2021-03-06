import {ImageCollection} from "../../../avatar/definitions/ImageCollection";
import {Account} from "../../../account/definitions/entity/Account";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {Backdrop} from "../../../backdrop/definitions/Backdrop";

export enum ProfileGender {
    None = <any> "none",
    Male = <any> "male",
    Female = <any> "female"
}

export const PROFILE_GENDER_LIST = [
    ProfileGender.None,
    ProfileGender.Male,
    ProfileGender.Female
];

export interface ProfileExtendedEntity {
    collections: CollectionEntity[];
    profile: ProfileEntity;
    is_own: boolean;
}

export interface ProfileEntity {
    id: number;
    sid: string;
    date_created_on: string;
    account_id: number;
    is_current: boolean;
    is_initialized: boolean;
    birthday?: string;
    interesting_in_ids: Array<number>;
    expert_in_ids: Array<number>;
    image: ImageCollection;
    backdrop: Backdrop<any>;
    greetings: ProfileGreetingsEntity;
    gender: ProfileGenderEntity;
    disabled: ProfileDisabledEntity;
}

export interface ProfileIndexedEntity extends ProfileEntity {
    _id: string;
}

export interface ProfileGreetingsEntity {
    method: string;
    greetings: string;
    first_name: string;
    last_name: string;
    middle_name: string;
    nick_name: string;
}

export interface ProfileGenderEntity {
    int: number;
    string: string;
}

export interface ProfileDisabledEntity {
    is_disabled: boolean;
    reason: string;
}

export class Profile {
    constructor(public owner: Account, public entity: ProfileExtendedEntity) {
    }

    getId(): number {
        return this.entity.profile.id
    }

    changeGreetings(greetings) {
        this.entity.profile.greetings = JSON.parse(JSON.stringify(greetings));
    }

    greetings(): string {
        return this.entity.profile.greetings.greetings;
    }

    public isCurrent(): boolean {
        return !!this.entity.profile.is_current;
    }

    public replaceAvatar(image: ImageCollection) {
        this.entity.profile.image = image;
    }

    public getAvatar(): ImageCollection {
        return this.entity.profile.image;
    }

    public setAsCurrent(): Profile {
        this.entity.profile.is_current = true;

        return this;
    }

    public unsetAsCurrent(): Profile {
        this.entity.profile.is_current = false;

        return this;
    }
}