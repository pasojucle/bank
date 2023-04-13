<template>
    <div class="input-group input-group-sm flex-nowrap">
        <span class="input-group-text" id="addon-wrapping"><i class="bi bi-search"></i></span>
        <input v-model="store.filter.needle" class="form-control form-control-sm" type="search" placeholder="Rechercher" aria-label="Search">
    </div>
</template>

<script>
const routes = require('../../web/js/fos_js_routes.json');
import { store } from './store.js'

export default {
    data() {
        return {
            store,
        }
    },
    created() {
        const el = this.store.getDomElement('#v-search-filter');
    },
}
</script>