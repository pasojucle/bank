document.addEventListener("DOMContentLoaded", function() {
    initModal();
});

const initModal = () => {
    console.log('modal-dynamic', document.querySelectorAll('[data-bs-toggle="modal-dynamic"]'));
    document.querySelectorAll('[data-bs-toggle="modal-dynamic"]').forEach(element => element.addEventListener('click', loadModal));
}

const loadModal = (event) => {
    console.log('Modale - loadModal')
    event.preventDefault();
    const route = event.target.href;
    fetch(route, {
        headers: {
            'Content-Type': 'text/plain',
        }
    })
    .then((response) => response.text())
    .then((text)=> {
        let htmlElement = document.createRange().createContextualFragment(text);
        const options = {'backdrop' : 'static'};
        const modal = new bootstrap.Modal(htmlElement.querySelector('#clue-modal'), options);
        modal.show();
    })
}

export { loadModal }