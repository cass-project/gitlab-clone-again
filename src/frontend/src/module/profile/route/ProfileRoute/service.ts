import {Injectable} from "angular2/core";
import {Observable} from "rxjs/Observable";

import {ProfileExtendedEntity} from "../../definitions/entity/Profile";
import {Response} from "angular2/http";
import {ProfileRESTService} from "../../service/ProfileRESTService";
import {GetProfileByIdResponse200} from "../../definitions/paths/get-by-id";
import {CurrentProfileService} from "../../service/CurrentProfileService";
import {ProfileCachedIdentityMap} from "../../service/ProfileCachedIdentityMap";
import {ProfileModals} from "../../modals";

@Injectable()
export class  ProfileRouteService
{
    private request: string;
    private cache: ProfileCachedIdentityMap;

    private profile: ProfileExtendedEntity;
    private loading: boolean = false;
    private observable: Observable<Response>;

    constructor(
        private api: ProfileRESTService,
        private cache: ProfileCachedIdentityMap,
        private current: CurrentProfileService,
        public modals: ProfileModals
    ) {}
    
    public isProfileLoaded(): boolean {
        return typeof this.profile == "object";
    }
    
    public isLoading(): boolean {
        return this.loading;
    }
    
    public getObservable(): Observable<GetProfileByIdResponse200> {
        return this.observable;
    }

    public getProfile(): ProfileExtendedEntity {
        if(!this.profile) {
            throw new Error('Profile is not loaded');
        }

        return this.profile;
    }

    public getProfileRouteComponents() {
        return ['/', 'Profile', 'Profile', { 'id': this.request }];
    }

    public loadCurrentProfile() {
        this.request = 'current';

        this.loadProfile(new Observable(observer => {
            observer.next({
                success: true,
                entity: this.current.get().entity
            });
            observer.complete();
        }));
    }

    public loadProfileById(id: number) {
        this.request = id.toString();

        this.loadProfile(this.cache.getProfileById(id));
    }

    public loadProfileBySID(sid: string) {
        this.request = sid;

        this.loadProfile(<any>this.api.getProfileBySID(sid));
    }
    
    private loadProfile(observable: Observable<GetProfileByIdResponse200>) {
        this.profile = undefined;
        this.loading = true;
        this.observable = observable;
        this.observable.subscribe(
            (response: GetProfileByIdResponse200) => {
                this.profile = response.entity;
                this.loading = false;
            },
            (error) => {
                this.loading = false;
            }
        )
    }

    public getProfileObservable() {
        return this.observable;
    }
}