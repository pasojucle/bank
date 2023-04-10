<template>
    <div class="input-group input-group-sm flex-nowrap ms-auto">
        <span class="input-group-text" id="addon-wrapping"><i class="bi bi-search"></i></span>
        <input  v-model="store.needle" class="form-control form-control-sm" type="search" placeholder="Rechercher" aria-label="Search">
    </div>
</template>

<script>
const routes = require('../../web/js/fos_js_routes.json');
import { store } from './store.js'

export default {
    data() {
        return {
            store
        }
    },
}
</script>