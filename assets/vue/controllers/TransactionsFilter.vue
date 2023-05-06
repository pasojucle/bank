<template>
    <nav class="nav bg-body-tertiary nav-pills">
        <div class="nav-link pe-2 ps-0">
            <a :href="pathNew()" class="btn btn-sm btn-primary" data-bs-toggle="modal-dynamic" data-bs-target="#clue-modal" role="button"><i class="bi bi-plus-lg d-sm-none"></i><span class="d-none d-sm-block">Nouvelle opération</span></a>
        </div>
        <div class="nav-link px-0">
            <TransactionsUplaod :account="account" :form="form" />
        </div>
        <div class="nav-link pe-2 ps-0 ms-auto">
            <input @click="handleChecked($event)" type="checkbox" class="btn-sm btn-check" id="btn-check-outlined" autocomplete="off">
            <label class="btn btn-sm btn-outline-primary" for="btn-check-outlined"><i class="bi bi-check-lg"></i></label><br>
        </div>
        <div class="nav-link px-0">
            <div class="input-group input-group-sm flex-nowrap">
                <span class="input-group-text" id="addon-wrapping"><i class="bi bi-search"></i></span>
                <input v-model="store.filter.needle" class="form-control form-control-sm" type="search" placeholder="Rechercher" aria-label="Search">
            </div>
        </div>
    </nav> 
</template>

<script>
const routes = require('../../../web/js/fos_js_routes.json');
import TransactionsUplaod from './TransactionsUpload.vue';
import { store } from './store.js'
import Routing from 'fos-router';

export default {
    props: {
        account: Number,
    },
    components: {
        TransactionsUplaod,
    },
    data() {
        return {
            store,
        }
    },
    methods: {
        pathNew() {
            return Routing.generate('transaction_new', {'account': this.account});
        },
        handleChecked(event) {
            this.store.filter.checked = event.target.checked;
        }
    },
}
</script>