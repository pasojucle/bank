<template>
    <div class="col" v-for="account in store.list.account" :key="account.id">
        <div class="card text-bg-primary mb-3">
            <div class="card-header">
                <h2>{{ account.name }}</h2>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ account.name }}</h5>
                <p class="card-text">{{ account.actualBalance }}</p>
                <div class="btn-group text-end">
                    <a v-bind:href="path(account)" @click.prevent="edit($event)" class="btn btn-light" data-bs-toggle="modal-dynamic" data-bs-target="#clue-modal" role="button">Nouvelle opération</a>
                    <a class="btn btn-outline-light" href="#">Consulter</a>
                </div>

            </div>
        </div>
    </div>
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
        path(account) {
            return Routing.generate('transaction_new', {'account': account.id});
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