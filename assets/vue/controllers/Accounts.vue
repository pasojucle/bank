<template>
    <tr v-for="account in store.listFiltered('account')" :key="account.id">
        <td>{{ account.name }}</td>
        <td><a v-bind:href="path(account)" @click.prevent="edit($event)" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal-dynamic" data-bs-target="#clue-modal" role="button">Modifier</a></td>
    </tr>
</template>

<script>
const routes = require('../../../web/js/fos_js_routes.json');
import Routing from 'fos-router';
import { loadModal } from '../../js/modal'
import { store } from './store.js'

export default {
    data() {
        return {
            store
        }
    },
    methods: {
        path(account) {
            return Routing.generate('account_edit', {'id': account.id});
        },
        edit(event) {
            loadModal(event);
        },
    },
    created() {
        this.store.getList('account');
    },
}
</script>