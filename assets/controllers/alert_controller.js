import { Controller } from 'stimulus';

export default class extends Controller {
    static targets = ['svg', 'icon', 'message'];

    showSuccess() {
        this.svgTarget.classList.add('bg-green-500');
        this.iconTarget.innerHTML =
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
        this.messageTarget.innerHTML = 'Votre demande de contact a bien été envoyée !';

        this.animate();
    }

    showError() {
        this.svgTarget.classList.add('bg-red-500');
        this.iconTarget.innerHTML =
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
        this.messageTarget.innerHTML = "Désolé, votre demande n'a pas pu être envoyée.";

        this.animate();
    }

    animate() {
        this.element.classList.remove('hidden');
        this.element.classList.add('animate-in');

        setTimeout(() => {
            this.element.classList.remove('animate-in');
            this.element.classList.add('animate-out');
        }, 5000);

        setTimeout(() => {
            this.element.classList.remove('animate-out');
            this.element.classList.add('hidden');
        }, 5000);
    }
}
