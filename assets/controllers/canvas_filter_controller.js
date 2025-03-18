import { Controller } from '@hotwired/stimulus';
import { Offcanvas } from 'bootstrap';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static values = {
        hasErrors: Boolean,
    }

    connect() {
        if (this.hasErrorsValue) {
            let offcanvas = new Offcanvas(this.element, {
                backdrop: false  // Désactive le backdrop
            });

            // Désactiver les transitions CSS
            this.element.style.transitionProperty = 'none';

            // Montrer l'offcanvas
            offcanvas.show();

            // Alternative: si vous voulez que le backdrop soit visible mais sans animation
            // Créez un backdrop manuellement
            if (document.querySelector('.offcanvas-backdrop') === null) {
                const backdrop = document.createElement('div');
                backdrop.classList.add('offcanvas-backdrop', 'show');
                backdrop.style.transitionProperty = 'none';
                document.body.appendChild(backdrop);
            }
        }
    }
}