<template>
    <div class="text-capitalize">
        <h1>{{ getAccount('name')}}</h1>
    </div>
    <div class="row align-items-baseline">
        <div class="col-md-4 col-7 fs-1">{{ getAccount('actualBalance') }} € </div>
        <div class="col-md-3 col-5">{{ getAccount('checkedBalance') }} € <i class="bi bi-check-circle-fill"></i></div>
    </div>
</template>

<script>
const routes = require('../../web/js/fos_js_routes.json');
import Routing from 'fos-router';

import { store } from './store.js'

export default {
    data() {
        return {
            store,
            id: '',
        }
    },
    methods: {
        path(account) {
            return Routing.generate('account_edit', {'id': account.id});
        },
        getAccount(property) {
            const account = this.store.listFindById('account', this.id);
            console.log('account', account)
            if(account) {
                return account[property]
            }
        }
    },
    created() {
        this.id = this.store.getDomElement('#v-account').getAttribute('data-account');
        this.store.edit('account', {'id': this.id});
    },
}
</script>