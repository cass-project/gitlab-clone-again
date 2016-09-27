import {ContentTypeCriteria} from "./component/Criteria/ContentTypeCriteria/index";
import {QueryStringCriteria} from "./component/Criteria/QueryStringCriteria/index";
import {SeekCriteria} from "./component/Criteria/SeekCriteria/index";
import {ThemeCriteria} from "./component/Criteria/ThemeCriteria/index";
import {PublicComponent} from "./component/Public/index";
import {SourceSelector} from "./component/Elements/SourceSelector/index";
import {NothingFound} from "./component/Elements/NothingFound/index";
import {ViewOptionService} from "./component/Options/ViewOption/service";
import {CollectionsRoute} from "./route/sources/CollectionsRoute/index";
import {CommunitiesRoute} from "./route/sources/CommunitiesRoute/index";
import {ContentRoute} from "./route/sources/ContentRoute/index";
import {ProfilesRoute} from "./route/sources/ProfilesRoute/index";
import {ExpertsRoute} from "./route/sources/ExpertsRoute/index";
import {PublicRoute} from "./route/root/index";
import {PublicContentMenu} from "./route/sources/ContentRoute/component/PublicContentMenu/index";

export const CASSPublicComponent = {
    declarations: [
        PublicComponent,
        ContentTypeCriteria,
        QueryStringCriteria,
        SeekCriteria,
        ThemeCriteria,
        NothingFound,
        SourceSelector,
        PublicContentMenu,
    ],
    routes: [
        PublicRoute,
        CollectionsRoute,
        CommunitiesRoute,
        ContentRoute,
        ExpertsRoute,
        ProfilesRoute,
    ],
    providers: [
        ViewOptionService,
    ],
};