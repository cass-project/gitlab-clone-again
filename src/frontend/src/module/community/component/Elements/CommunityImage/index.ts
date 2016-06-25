import {Component, Input} from "angular2/core";

@Component({
    selector: 'cass-community-image',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityImage
{
    @Input('url') url: string;
    @Input('border') border: string = 'circle';

    static allowedBorders = ['circle', 'square'];

    getURL() {
        return this.url;
    }

    getCSSClasses() {
        let border = this.border;

        if(!~CommunityImage.allowedBorders.indexOf(border)) {
            throw new Error(`Invalid border ${border}`);
        }

        return `community-image-border community-image-border-${border}`;
    }
}