import { useIntersection } from 'stimulus-use';
import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        useIntersection(this)
    }

    appear() {
        if (!this.element.classList.contains('animate')) this.element.classList.add('animate')
    }
}