import {Injectable} from "@angular/core";
import {AuthRESTService} from "./AuthRESTService";
import {Account} from "./../../account/definitions/entity/Account";
import {SignInRequest, SignInResponse200} from "../definitions/paths/sign-in";
import {SignUpRequest, SignUpResponse200} from "../definitions/paths/sign-up";
import {AuthToken} from "./AuthToken";
import {FrontlineService} from "../../frontline/service/FrontlineService";

@Injectable()
export class AuthService
{
    private current: Account;

    constructor(
        private token: AuthToken,
        private frontline: FrontlineService,
        private api: AuthRESTService
    ) {
        if(token.isAvailable()) {
            this.current = new Account(
                this.frontline.session.auth.account,
                this.frontline.session.auth.profiles
            );
        }
    }

    public getCurrentAccount(): Account
    {
        return this.current;
    }

    public isSignedIn(): boolean {
        return this.token.isAvailable();
    }

    public signUp(request: SignUpRequest) {
        let signUpObservable = this.api.signUp(request);

        signUpObservable.subscribe(
            (response: SignUpResponse200) => {
                this.current = new Account(response.account, response.profiles);
                this.token.setToken(response.api_key);
                localStorage.setItem('api_key', response.api_key);
            },
            error => {}
        );

        return signUpObservable;
    }

    public signIn(request: SignInRequest) {
        let signInObservable = this.api.signIn(request);

        signInObservable.subscribe(
            (response: SignInResponse200) => {
                this.current = new Account(response.account, response.profiles);
                this.token.setToken(response.api_key);
                localStorage.setItem('api_key', response.api_key);
            },
            error => {}
        );

        return signInObservable;
    }
    
    public signInWithAPIKey(apiKey: string) {
        this.token.setToken(apiKey);
        localStorage.setItem('api_key', apiKey);
    }

    public signOut() {
        let request = this.api.signOut();

        request.subscribe(
            () => {
                this.token.clearAPIKey();
                localStorage.removeItem('api_key');
            }
        );

        return request;
    }
}