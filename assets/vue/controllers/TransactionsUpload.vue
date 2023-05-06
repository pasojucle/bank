<template>
    <div>
        <button @click="open($event)" class="btn btn-sm btn-outline-primary"><i class="bi bi-upload d-sm-none"></i><span class="d-none d-sm-block">Importer un fichier</span></button>
        <div id="container" class="d-none"></div>
    </div>
</template>

<script>
import { store } from './store.js'
const routes = require('../../../web/js/fos_js_routes.json');
import Routing from 'fos-router';

export default {
    props: {
        account: Number,
        form: Object,
    },
    data() {
        return {
            file: '',
            store,
        }
    },
    methods: {
        open() {
            this.file.click();
        },
        async formCreate() {
            await fetch(Routing.generate(`transaction_upload`, {'account': this.account}))
                .then(response => response.text())
                .then(data => {
                    console.log('data', data);
                    this.$el.querySelector('#container').insertAdjacentHTML('afterbegin', data);
                    this.file = this.$el.querySelector('input[type="file"]');
                    this.file.addEventListener('change', this.submit);
                });
        },
        submit(event) {
            event.target.closest('form').submit();
        }
    },
    created() {
        this.formCreate();
    },
}
</script>