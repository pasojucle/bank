<template>
    <tr v-for="transaction in store.list.transaction" :key="transaction.id">
        <td>{{ transaction.label.name }}</td>
        <td class="text-end">{{ transaction.amount }}</td>
        <td><a v-bind:href="path(transaction)" @click.prevent="edit($event)" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal-dynamic" data-bs-target="#clue-modal" role="button">Modifier</a></td>
    </tr>
</template>

<script>
const routes = require('../../web/js/fos_js_routes.json');
import Routing from 'fos-router';
import { loadModal } from '../js/modal'
import { store } from './store.js'

export default {
    data() {
        return {
            store
        }
    },
    methods: {
        path(transaction) {
            return Routing.generate('transaction_edit', {'id': transaction.id});
        },
        edit(event) {
            loadModal(event);
        },
    },
    created() {
        const el = this.store.getDomElement('#v-transactions');
        this.store.getList('transaction', {'account': el.getAttribute('data-account')});
    },
}
</script>