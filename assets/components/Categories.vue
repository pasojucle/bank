<template>
    <tr v-for="category in store.list.categories" :key="category.id">
        <td>{{ category.name }}</td>
        <td><a v-bind:href="path(category)" @click.prevent="edit($event)" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal-dynamic" data-bs-target="#clue-modal" role="button">Modifier</a></td>
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
            await fetch("/api/category", {"method": "GET"})
            .then(response => response.json())
            .then(data => {
                this.store.list.categories = data.categories;
            });
        },
        path(category) {
            return Routing.generate('category_edit', {'id': category.id});
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