<template>
    <tr v-for="transaction in store.transactionListFiltered()" :key="transaction.id">
        <td>{{ transaction.createdAtStr }}</td>
        <td>{{ transaction.label.name }}</td>
        <td class="text-end">{{ transaction.amount }}</td>
        <td><i :class="(transaction.checkedToStr)"></i></td>
        <td>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
                <ul class="dropdown-menu">
                    <li><a :data-id="(transaction.id)" @click.prevent="check($event)" class="dropdown-item" role="button"><i class="bi bi-check2-square"></i> Pointer</a></li>
                    <li><a :href="pathEdit(transaction)" @click.prevent="edit($event)" class="dropdown-item" data-bs-toggle="modal-dynamic" data-bs-target="#clue-modal" role="button"><i class="bi bi-pencil-square"></i> Modifier</a></li>
                </ul>
            </div>
        </td>
    </tr>
</template>

<script>
const routes = require('../../../web/js/fos_js_routes.json');
import Routing from 'fos-router';
import { loadModal } from '../../js/modal'
import { store } from './store.js'

export default {
    props: {
        account: Number,
    },
    data() {
        return {
            store,
        }
    },
    methods: {
        pathEdit(transaction) {
            return Routing.generate('transaction_edit', {'id': transaction.id});
        },
        edit(event) {
            loadModal(event);
        },
        check(event) {
            this.store.transactionCheck(event.target.dataset.id);
        },
    },
    created() {
        console.log('transactions account', this.account)
        this.store.getList('transaction', {'account': this.account});
    },
}
</script>