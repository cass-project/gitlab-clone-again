import {Component} from "@angular/core";

import {FeedService} from "../../../feed/service/FeedService/index";
import {Stream} from "../../../feed/service/FeedService/stream";
import {PublicService} from "../../service";
import {PublicProfilesSource} from "../../../feed/service/FeedService/source/public/PublicProfilesSource";
import {ProfileIndexedEntity} from "../../../profile/definitions/entity/Profile";
import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        PublicService,
        FeedService,
        PublicProfilesSource,
        FeedCriteriaService,
        FeedOptionsService,
    ]
})
export class ProfilesRoute
{
    constructor(
        private catalog: PublicService,
        private service: FeedService<ProfileIndexedEntity>,
        private source: PublicProfilesSource
    ) {
        catalog.source = 'profiles';
        catalog.injectFeedService(service);
        
        service.provide(source, new Stream<ProfileIndexedEntity>());
        service.update();
    }
}