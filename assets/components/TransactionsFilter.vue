<template>
    <nav class="nav bg-body-tertiary nav-pills">
        <div class="nav-link px-0">
            <a href="{{ path('transaction_new', {'account': account.id }) }}" class="btn btn-sm btn-primary" data-bs-toggle="modal-dynamic" data-bs-target="#clue-modal" role="button"><i class="bi bi-plus-lg d-sm-none"></i><span class="d-none d-sm-block ms-2">Nouvelle opération</span></a>
        </div>
        <div class="nav-link pe-2 ms-auto">
            <input @click="handleChecked($event)" type="checkbox" class="btn-sm btn-check" id="btn-check-outlined" autocomplete="off">
            <label class="btn btn-sm btn-outline-primary" for="btn-check-outlined"><i class="bi bi-check-lg"></i></label><br>
        </div>
        <div class="nav-link px-0">
            <div class="input-group input-group-sm flex-nowrap">
                <span class="input-group-text" id="addon-wrapping"><i class="bi bi-search"></i></span>
                <input  v-model="store.transactionsFilter.needle" class="form-control form-control-sm" type="search" placeholder="Rechercher" aria-label="Search">
            </div>
        </div>
    </nav> 
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
    methods: {
        handleChecked(event) {
            this.store.transactionsFilter.checked =  event.target.checked;
        }
    }
}
</script>