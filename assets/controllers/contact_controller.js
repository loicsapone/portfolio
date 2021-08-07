import { Controller } from 'stimulus';
import { useDispatch } from 'stimulus-use';

export default class extends Controller {
    connect() {
        useDispatch(this);
    }

    onSubmit(event) {
        event.preventDefault();

        fetch(this.element.action, {
            method: this.element.method,
            body: new FormData(this.element),
        }).then(response => {
            if (response.ok) {
                this.dispatch('success');
                this.element.reset();
            } else {
                this.dispatch('error');
            }
        });
    }
}
