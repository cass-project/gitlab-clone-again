import {Component, Directive} from "@angular/core";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})
@Directive({selector: 'cass-public-nothing-found'})

export class NothingFound
{}