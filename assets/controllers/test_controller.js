import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['output', 'divBtn'];
    btnCount = 0;

    connect() {
        // console.log('Connected <3');
    }

    greet() {
        this.outputTarget.textContent = 'Bonjour, Stimulus !';
    }

    addBtn(){
        this.btnCount++;
        const button = document.createElement('button');
        button.textContent = `BTN_${this.btnCount}`;
        button.classList.add('btn', 'btn-warning'); // Exemples de classes CSS
        this.divBtnTarget.appendChild(button);
    }
}