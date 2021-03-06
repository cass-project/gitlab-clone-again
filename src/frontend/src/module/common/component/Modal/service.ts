import {Injectable} from "@angular/core";

import {ModalComponent} from "./index";

@Injectable()
export class ModalService
{
    private count = 0;
    private modals = { property: ModalComponent };

    attach(component: ModalComponent) {
        ++this.count;
        this.modals[component.getId()] = component;
    }

    detach(component: ModalComponent) {
        --this.count;
        delete this.modals[component.getId()];
    }

    has(component: ModalComponent) {
        return this.modals.hasOwnProperty(component.getId());
    }

    hasModals() {
        return this.count > 0;
    }
}