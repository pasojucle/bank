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
const routes = require('../../../web/js/fos_js_routes.json');

import { store } from './store.js'

export default {
    props: {
        id: Number,
    },
    data() {
        return {
            store,
        }
    },
    methods: {
        getAccount(property) {
            const account = this.store.listFindById('account', this.id);
            console.log('account', account)
            if(account) {
                return account[property]
            }
        }
    },
    created() {
        console.log('account id', this.id)
        this.store.edit('account', {'id': this.id});
    },
}
</script>