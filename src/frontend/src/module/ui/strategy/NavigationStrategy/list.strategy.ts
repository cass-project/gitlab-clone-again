import {ElementRef} from "@angular/core";
import {UIStrategy} from "./ui.strategy";

export class ListStrategy implements UIStrategy
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
        let prev = 0;
        if(this.elements.length > 0){
            for(let index = 0; index < this.elements.length; index++){
                if(this.elements[index].classList.contains('x-navigation-entity-active') && index > 0){
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

    down()
    {
        let next = 0;
        if(this.elements.length > 0){
            for(let index = 0; index < this.elements.length; index++){
                if(this.elements[index].classList.contains('x-navigation-entity-active') && index < this.elements.length - 1){
                    this.elements[index].classList.remove('x-navigation-entity-active');
                    next = index + 1;
                    break;
                }
            }
        }
        this.elements[next].classList.add('x-navigation-entity-active');
        this.pickedElem = this.elements[next];

        this.scrollIntoView(this.elements[next]);
    }

    top()
    {
        this.content.nativeElement.scrollTop = 0;
    }

    bottom() {
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