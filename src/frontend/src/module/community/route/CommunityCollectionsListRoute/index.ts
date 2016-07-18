import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES} from "angular2/router";

import {CollectionsList} from "../../../collection/component/Elements/CollectionsList/index";
import {CommunityRouteService} from "../CommunityRoute/service";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CollectionsList,
    ]
})
export class CommunityCollectionsListRoute
{
    constructor(private service: CommunityRouteService) {}
}