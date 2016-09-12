import {Component, Directive} from "@angular/core";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
@Directive({selector: 'cass-attachment-error'})

export class AttachmentError
{}