import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        setTimeout(() => {
            this.element.classList.remove('animate-in')
            this.element.classList.add('animate-out')
            setTimeout(() => this.element.remove(), 500)
        }, 5000)
    }
}