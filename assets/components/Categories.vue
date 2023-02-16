<template>
    <tr v-for="category in categoryList">
        <td>{{ category.name }}</td>
        <td><a v-bind:href="path(category)" v-on:click="loadModal" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal-dynamic" data-bs-target="#clue-modal" role="button">Modifier</a></td>
    </tr>
</template>

<script>
const routes = require('../../web/js/fos_js_routes.json');
import Routing from 'fos-router';
import { loadModal } from '../js/modal'

export default {
    data() {
        return {
            categoryList: [],
        }
    },
    methods: {
        getCategories() {
            fetch("/api/category", {"method": "GET"})
            .then(response => response.json())
            .then(result => {
                this.categoryList = result.categories;
            });
            
        },
        path(category) {
            return Routing.generate('category_edit', {'id': category.id});
        },
        loadModal(event) {
            loadModal(event);
        }
    },
    created() {
        this.getCategories()
    },
}
</script>