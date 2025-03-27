import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["modal"];

    openModal() {
        this.modalTarget.classList.remove("hidden");
    }

    closeModal() {
        this.modalTarget.classList.add("hidden");
    }

    backdropClick(event) {
        if (event.target === this.modalTarget) {
            this.closeModal();
        }
    }
}