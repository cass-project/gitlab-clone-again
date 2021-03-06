import {ElementRef} from "@angular/core";
import {UIStrategy} from "./ui.strategy";

export class FeedStrategy implements UIStrategy
{
    private pickedElem;
    content: ElementRef;
    elements;

    constructor(private elem: ElementRef)
    {
        this.content = elem;
        this.elements = this.content.nativeElement.getElementsByClassName('x-navigation-entity');
    }

    up()
    {
        let cur = 0;
        let step = 0;
        if (this.elements.length > 0) {
            for (let index = 0; index < this.elements.length; index++) {
                if (this.elements[index].classList.contains('x-navigation-entity-active')) {
                    this.elements[index].classList.remove('x-navigation-entity-active');
                    cur = index;
                    step = cur - 1;
                    break;
                }
            }
            let prev = cur;
            for (let index = step; index >= 0; index--) {

                // Previous item with same X.
                if (this.elements[index].getBoundingClientRect().left == this.elements[cur].getBoundingClientRect().left) {
                    prev = index;
                    break;
                }
            }
            this.elements[prev].classList.add('x-navigation-entity-active');
            this.pickedElem = this.elements[prev];

            this.scrollIntoView(this.elements[prev]);
        }
    }

    down()
    {
        let cur = 0;
        let step = 0;
        if (this.elements.length > 0) {
            for (let index = 0; index < this.elements.length; index++) {
                if (this.elements[index].classList.contains('x-navigation-entity-active')) {
                    this.elements[index].classList.remove('x-navigation-entity-active');
                    cur = index;
                    step = cur + 1;
                    break;
                }
            }
            let next = cur;
            for (let index = step; index < this.elements.length; index++) {

                // Next item with same X.
                if (this.elements[index].getBoundingClientRect().left == this.elements[cur].getBoundingClientRect().left) {
                    next = index;
                    break;
                }
            }

            this.elements[next].classList.add('x-navigation-entity-active');
            this.pickedElem = this.elements[next];

            this.scrollIntoView(this.elements[next]);
        }
    }

    left()
    {
        let prev = 0;
        if(this.elements.length > 0){
            for(let index = 0; index < this.elements.length; index++){
                if(this.elements[index].classList.contains('x-navigation-entity-active') && index > 0) {
                    this.elements[index].classList.remove('x-navigation-entity-active');
                    prev = index - 1;
                    break;
                }
            }
        }
        this.elements[prev].classList.add('x-navigation-entity-active');
        this.pickedElem = this.elements[prev];

        this.scrollIntoView(this.elements[prev]);
    }

    right() {
        let next = 0;
        if(this.elements.length > 0){
            for(let index = 0; index < this.elements.length; index++){
                if(this.elements[index].classList.contains('x-navigation-entity-active') && index < this.elements.length - 1) {
                    this.elements[index].classList.remove('x-navigation-entity-active');
                    next = index + 1;
                    break;
                }
            }
        }
        this.elements[next].classList.add('x-navigation-entity-active');
        this.pickedElem = this.elements[next];
        
        this.scrollIntoView(this.elements[next])
    }

    top()
    {
        this.content.nativeElement.scrollTop = 0;
    }

    bottom()
    {
        this.content.nativeElement.scrollTop = this.content.nativeElement.scrollHeight;
    }

    enter()
    {
        if(this.pickedElem.getElementsByClassName('x-navigation-click').length > 0){
           this.pickedElem.getElementsByClassName('x-navigation-click')[0].click();
        }
    }
    
    scrollIntoView(elem){
        elem.scrollIntoView();
        this.content.nativeElement.scrollTop -= 10;
    }
}