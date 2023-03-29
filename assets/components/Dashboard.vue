<template>
    <div class="col" v-for="account in store.list.account" :key="account.id">
        <div class="card text-bg-primary mb-3">
            <div class="card-header">
                <h2 class="text-capitalize">{{ account.name }}</h2>
            </div>
            <div class="card-body">
                <div class="card-text">
                    <div class="actual-balance row align-items-end">
                        <div class="col-3">Réel</div>
                        <div class="col-9 text-end fs-1">{{ account.actualBalance }}</div>
                    </div>
                    <div class="checked-balance row align-items-end">
                        <div class="col-3">Pointé</div>
                        <div class="col-9 text-end">{{ account.checkedBalance }}</div>
                    </div>
                </div>
                <!-- <div class="d-flex justify-content-end"> -->
                    <div class="btn-group mt-2 w-100">
                        <a v-bind:href="newTransaction(account)" @click.prevent="edit($event)" class="btn btn-light" data-bs-toggle="modal-dynamic" data-bs-target="#clue-modal" role="button">Nouvelle opération</a>
                        <a v-bind:href="transactions(account)" class="btn btn-outline-light">Consulter</a>
                    </div> 
                <!-- </div> -->
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
            store,
        }
    },
    methods: {
        newTransaction(account) {
            return Routing.generate('transaction_new', {'account': account.id});
        },
        transactions(account) {
            return Routing.generate('transaction_index', {'account': account.id});
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