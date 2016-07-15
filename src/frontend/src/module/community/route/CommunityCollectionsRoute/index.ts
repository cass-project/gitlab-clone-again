import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES, RouteConfig} from "angular2/router";
import {CommunityCollectionsListRoute} from "../CommunityCollectionsListRoute/index";
import {CommunityCollectionRoute} from "../CommunityCollectionRoute/index";
import {CommunityCollectionNotFoundRoute} from "../CommunityCollectionNotFoundRoute/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
    ]
})
@RouteConfig([
    {
        path: '/',
        name: 'List',
        component: CommunityCollectionsListRoute,
        useAsDefault: true
    },
    {
        path: '/not-found',
        name: 'NotFound',
        component: CommunityCollectionNotFoundRoute
    },
    {
        path: '/:sid',
        name: 'View',
        component: CommunityCollectionRoute
    },
])
export class CommunityCollectionsRoute
{

}