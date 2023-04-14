<template>
    <button @click="submit($event)" type="submit" class="btn btn-primary">Enregistrer</button>
</template>


<script>
const routes = require('../../../web/js/fos_js_routes.json');

import { store } from './../store.js'

export default {
    methods: {
        async submit(event) {
            const form = event.target.closest('form');
            if (form.checkValidity()) {
                event.preventDefault();
                await fetch(form.action, {
                    method: "POST",
                    body : new FormData(form),
                    headers: {
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    console.log('update', data)
                    store.updateAll(data);
                    form.querySelector('[data-bs-dismiss="modal"]').click()
                });
            }
        }
    },
}
</script>