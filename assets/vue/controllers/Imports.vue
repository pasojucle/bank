<template>
    <tr v-for="transaction in store.list.import" :key="transaction.id">
        <td>{{ transaction.createdAt }}</td>
        <td>{{ transaction.label.name }}</td>
        <td class="text-end">{{ transaction.amount }}</td>
        <td><i :class="(transaction.checkedToStr)"></i></td>
        <td v-if="isLinked(transaction)">
            <i class="bi bi-link circle"></i>
        </td>
        <td v-else>
            <a :href="pathEdit(transaction)" @click.prevent="edit($event)" class="btn btn-primary btn-sm" data-bs-toggle="modal-dynamic" data-bs-target="#clue-modal" role="button"><i class="bi bi-box-arrow-in-down"></i></a>
        </td>
    </tr>
</template>

<script>
const routes = require('../../../web/js/fos_js_routes.json');
import Routing from 'fos-router';
import { store } from './store.js'
import { loadModal } from '../../js/modal'

export default {
    props: {
        account: Number,
        filename: String,
    },
    data() {
        return {
            store,
        }
    },
    methods: {
        pathEdit(transaction) {
            return Routing.generate('import_edit', {'id': transaction.id, 'account': this.account});
        },
        edit(event) {
            loadModal(event);
        },
        check(event) {
            this.store.transactionCheck(event.target.dataset.id);
        },
        isLinked(transaction) {
            return transaction.transactionId !== null;
        }
    },
    created() {
        console.log('import', this);
        this.store.getList('import', {'account': this.account, 'filename': this.filename});
        this.store.getList('transaction', {'account': this.account});
    },
}
</script>

<style scoped>
    .circle {
        border: 2px solid var(--bs-primary);
        border-radius: 50%;
        padding: .1rem .2rem;
        color: var(--bs-primary);
    }
</style>