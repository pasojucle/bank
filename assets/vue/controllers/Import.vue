<template>
    <div class="modal-body">
        <div class="header">{{ transaction.label.name }} : {{ transaction.amount }}</div>

        <div class="card-body">
            <table class="table table-striped table-sm table-responsive mt-2">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Libélé</th>
                        <th class="text-end">Montant</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="transaction in getTransactions()" :key="transaction.id">
                        <td>{{ transaction.createdAt }}</td>
                        <td>{{ transaction.label.name }}</td>
                        <td class="text-end">{{ transaction.amount }}</td>
                        <td>
                            <a @click="link($event)" :data-id="transaction.id" class="btn btn-primary btn-sm me-2"><i
                                    class="bi bi-link"></i></a>
                            <a @click.prevent="edit($event)" :data-id="transaction.id" class="btn btn-primary btn-sm"><i
                                    class="bi bi-pencil-fill"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <a @click.prevent="fromImport($event)" :data-id="transaction.id" class="btn btn-primary">Ajouter</a>

    </div>
</template>

<script>
import { store } from './store.js';
import Routing from 'fos-router';
import { createModal } from '../../js/modal';

export default {
    props: {
        account: Number,
        id: Number,
    },
    data() {
        return {
            transaction: {},
            store,
        }
    },
    methods: {
        link(event) {
            const modal = bootstrap.Modal.getInstance('#' + document.querySelector('.modal').id);
            this.transaction.transactionId = event.target.dataset.id
            this.store.transactionCheck(event.target.dataset.id);
            modal.hide();
        },
        async edit(event) {
            await fetch(Routing.generate('transaction_edit', { 'id': event.target.dataset.id}), {
                method: "GET",
            })
                .then(response => response.text())
                .then(text => {
                    document.querySelector('[data-bs-dismiss="modal"]').click()
                    createModal('#clue-modal', text)
                });
        },
        async fromImport(event) {
            const item = this.store.listFindById('import', event.target.dataset.id)
            const formData = new FormData();
            Object.entries(item).forEach(([name, value]) => {
                if (value instanceof Object) {
                    value = value.name
                }
                formData.append(`import[${name}]`, value);
            })
            await fetch(Routing.generate('transaction_from_import', { 'id': item.id }), {
                method: "POST",
                body: formData,
            })
                .then(response => response.text())
                .then(text => {
                    document.querySelector('[data-bs-dismiss="modal"]').click()
                    createModal('#clue-modal', text)
                });
        },
        getTransactions() {
            console.log('ransactons filtered', this.store.transactionListFiltered())
            return this.store.transactionListFiltered();
        },
    },
    created() {
        this.transaction = this.store.listFindById('import', this.id);
        console.log('store', this.store.list);
        console.log('import', this.transaction);
        this.store.filter = {
            needle: this.transaction.amount,
            checked: false
        }

    },
}
</script>


<style scoped>
.header {
    font-weight: 700;
    color: var(--bs-primary);
}

.bi.bi {
    pointer-events: none;
}
</style>