<template>

    <div>{{ account.name }}</div>
    <div>{{ account.actualBallance }}</div>
    <div>{{ account.checkedBallance }}</div>

</template>

<script>
const routes = require('../../web/js/fos_js_routes.json');
import Routing from 'fos-router';

import { store } from './store.js'

export default {
    data() {
        return {
            store,
            account: '',
        }
    },
    methods: {
        path(account) {
            return Routing.generate('account_edit', {'id': account.id});
        },
    },
    created() {
        const el = this.store.getDomElement('#v-account');
        this.store.edit('account', {'id': el.getAttribute('data-account')}).then(() => {
            
        });
    },
}
</script>