import {FeedEntity} from "./entity";

export class Stream<T>
{
    private entities: T[] = [];

    all(): T[] {
        return this.entities;
    }

    replace(entities: T[]) {
        this.entities = entities;
    }

    push(entities: T[]) {
        entities.forEach(entity => {
            this.entities.push(entity);
        })
    }

    insertBefore(entity: T) {
        this.entities.unshift(entity);
    }
}