<template>
    <tr v-for="cluster in store.list.cluster" :key="cluster.id">
        <td>{{ cluster.name }}</td>
        <td><a v-bind:href="path(cluster)" @click.prevent="edit($event)" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal-dynamic" data-bs-target="#clue-modal" role="button">Modifier</a></td>
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
        async getCategories() {
            await fetch("/api/cluster", {"method": "GET"})
            .then(response => response.json())
            .then(data => {
                this.store.list.cluster = data.clusters;
            });
        },
        path(cluster) {
            return Routing.generate('cluster_edit', {'id': cluster.id});
        },
        edit(event) {
            loadModal(event);
        },
    },
    created() {
        this.getCategories()
    },
}
</script>