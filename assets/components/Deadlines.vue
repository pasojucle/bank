<template>
    <tr v-for="deadline in store.listFiltered('deadline')" :key="deadline.id">
        <td>{{ deadline.label.name }}</td>
        <td class="text-end">{{ deadline.amount }}</td>
        <td><a v-bind:href="path(deadline)" @click.prevent="edit($event)" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal-dynamic" data-bs-target="#clue-modal" role="button">Modifier</a></td>
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
        path(deadline) {
            return Routing.generate('deadline_edit', {'id': deadline.id});
        },
        edit(event) {
            loadModal(event);
        },
    },
    created() {
        this.store.getList('deadline');
    },
}
</script>