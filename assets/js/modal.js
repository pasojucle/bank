import { mountModalComponents } from '../components/mountComponents.js'
import { initTableCheck } from './table_check.js';
var modalSelector = '[data-bs-toggle="modal-dynamic"]';
document.addEventListener("DOMContentLoaded", function() {
    initModal();
});

const initModal = () => {
    console.log('modal-dynamic', document.querySelectorAll('[data-bs-toggle="modal-dynamic"]'));
    document.querySelectorAll(modalSelector).forEach(element => element.addEventListener('click', (event) => {
        console.log('addEvent',element,  event.target)
        // if (element !== event.target) return;
        loadModal(event);
    }, false));
}

const loadModal = (event) => {
    event.preventDefault();
    let element = (event.target.dataset.bsToggle === 'modal-dynamic') ? event.target : event.target.closest(modalSelector);
    
    const modalTarget = element.dataset.bsTarget;
    console.log('bs-target', event.target)
    console.log('modalTarget', modalTarget)
    // dispose(modalTarget);

    const route = element.href;
    fetch(route, {
        headers: {
            'Content-Type': 'text/plain',
        }
    })
    .then((response) => response.text())
    .then((text)=> {
        const htmlElement = document.createRange().createContextualFragment(text);
        const htmlModal = htmlElement.querySelector('.modal');
        const options = {'backdrop' : 'static'};
        document.querySelector('body').append(htmlModal);
        const modal = new bootstrap.Modal(document.querySelector(modalTarget), options);
        console.log('modal', modal)
        const modalEl = modal._element;
        console.log('modalEl', modalEl)
        modal.show();

        modalEl.addEventListener('shown.bs.modal', event => {
            console.log('show', event.target)
            mountModalComponents();
            initTableCheck();
        })

        modalEl.addEventListener('hidden.bs.modal', event => {
            console.log('hide', event.target)
            modal.dispose()
            modalEl.remove();
        })
    })
}

const dispose = (modalTarget) => {
    const domModal = document.querySelector(modalTarget);
    if (domModal) {
        domModal.remove();
    }
}

export { loadModal }