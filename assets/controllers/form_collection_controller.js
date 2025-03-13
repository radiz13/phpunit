import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        addLabel: String,
        deleteLabel: String
    }

    /**
     * Injecte dynamiquement le bouton "Ajouter" et les boutons "Supprimer"
     */
    connect() {
        // Vérifier si ce contrôleur a déjà été initialisé pour éviter les doublons
        if (this.element.dataset.initialized === 'true') {
            return;
        }
        this.element.dataset.initialized = 'true';

        // Détermine si l'élément actuel est la collection elle-même ou son conteneur
        let collectionElement = this.element;

        // Si l'élément n'a pas d'attribut data-prototype, cherche un enfant qui l'a
        if (!this.element.hasAttribute('data-prototype')) {
            const prototypeElement = this.element.querySelector('[data-prototype]');
            if (prototypeElement) {
                collectionElement = prototypeElement;
            } else {
                console.error('Aucun élément avec data-prototype trouvé');
                return;
            }
        }

        // Compte le nombre d'enfants pour déterminer l'index initial
        this.index = collectionElement.childElementCount;

        // Créer le bouton d'ajout
        const addBtn = document.createElement('button');
        addBtn.setAttribute('class', 'btn btn-primary mt-2');
        addBtn.innerText = this.addLabelValue || 'Ajouter un élément';
        addBtn.setAttribute('type', 'button');
        addBtn.addEventListener('click', (e) => this.addElement(e, collectionElement));

        // Ajouter les boutons de suppression aux éléments existants
        Array.from(collectionElement.children).forEach(this.addDeleteButton);

        // Ajouter le bouton d'ajout à la fin de la collection
        this.element.appendChild(addBtn);
    }

    /**
     * Ajoute une nouvelle entrée dans la structure HTML
     *
     * @param {MouseEvent} e
     * @param {HTMLElement} collectionElement
     */
    addElement = (e, collectionElement) => {
        e.preventDefault();

        // Créer un nouveau design à partir du prototype
        const element = document.createRange().createContextualFragment(
            collectionElement.dataset.prototype.replaceAll('__name__', this.index)
        ).firstElementChild;

        // Ajouter le bouton de suppression
        this.addDeleteButton(element);

        // Incrémenter l'index pour le prochain ajout
        this.index++;

        // Ajouter l'élément à la collection
        collectionElement.appendChild(element);
    }

    /**
     * Ajoute le bouton pour supprimer une ligne
     *
     * @param {HTMLElement} item
     */
    addDeleteButton = (item) => {
        if (item && item.nodeType === Node.ELEMENT_NODE) {
            // Vérifier si un bouton de suppression existe déjà
            if (!item.querySelector('[data-action="delete"]')) {
                const btn = document.createElement('button');
                btn.setAttribute('class', 'btn btn-danger mt-2 ms-2');
                btn.setAttribute('data-action', 'delete');
                btn.innerText = this.deleteLabelValue || 'Supprimer';
                btn.setAttribute('type', 'button');

                // Trouver le meilleur endroit pour ajouter le bouton
                // Si c'est un fieldset avec une légende, ajouter après la légende
                const targetContainer = item.querySelector('.design-item') || item;

                // Ajouter le bouton à l'élément
                targetContainer.appendChild(btn);

                // Ajouter l'événement de suppression
                btn.addEventListener('click', e => {
                    e.preventDefault();
                    item.remove();
                });
            }
        }
    }
}