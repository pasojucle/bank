document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('[data-bs-toggle="modal-dynamic"]').forEach(element => {
        console.log('element', element);
        element.addEventListener('click', loadModal);
    })
});

const loadModal = (event) => {
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