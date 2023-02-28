<template>
    <tr v-for="label in store.list.label" :key="label.id">
        <td>{{ label.name }}</td>
        <td><a v-bind:href="path(label)" @click.prevent="edit($event)" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal-dynamic" data-bs-target="#clue-modal" role="button">Modifier</a></td>
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
        path(label) {
            return Routing.generate('label_edit', {'id': label.id});
        },
        edit(event) {
            loadModal(event);
        },
    },
    created() {
        this.store.getList('label');
    },
}
</script>