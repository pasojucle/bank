import { mountModalComponents } from '../components/mountComponents.js'

document.addEventListener("DOMContentLoaded", function() {
    initModal();
});

const initModal = () => {
    console.log('modal-dynamic', document.querySelectorAll('[data-bs-toggle="modal-dynamic"]'));
    document.querySelectorAll('[data-bs-toggle="modal-dynamic"]').forEach(element => element.addEventListener('click', loadModal));
}

const loadModal = (event) => {
    event.preventDefault();
    const modalTarget = event.target.dataset.bsTarget;
    dispose(modalTarget);
    const route = event.target.href;
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
        const domModal = new bootstrap.Modal(document.querySelector(modalTarget), options);

        domModal.show();

        mountModalComponents();
    })
}

const dispose = (modalTarget) => {
    const domModal = document.querySelector(modalTarget);
    if (domModal) {
        domModal.remove();
    }
}

export { loadModal }