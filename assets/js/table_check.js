export const initTableCheck = () => {
    document.querySelectorAll('.table-check > .form-check').forEach(element => {
        if (element.querySelector('input[type="checkbox"]').checked) {
            element.classList.add('checked');
        }
        element.addEventListener('click', toggleCheck);
    });
}

const toggleCheck = (event) => {
    const formCheck = event.target;
    const input = formCheck.querySelector('input[type="checkbox"]');
    if (formCheck.classList.contains('checked')) {
        formCheck.classList.remove('checked');
        input.removeAttribute('checked');
        return;
    }
    formCheck.classList.add('checked');
    input.setAttribute('checked', 'checked');
}