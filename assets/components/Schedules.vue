<template>
    <tr v-for="schedule in store.listFiltered('schedule')" :key="schedule.id">
        <td>{{ schedule.label.name }}</td>
        <td class="text-end">{{ schedule.amount }}</td>
        <td><a v-bind:href="path(schedule)" @click.prevent="edit($event)" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal-dynamic" data-bs-target="#clue-modal" role="button">Modifier</a></td>
    </tr>
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
        path(schedule) {
            return Routing.generate('schedule_edit', {'id': schedule.id});
        },
        edit(event) {
            loadModal(event);
        },
    },
    created() {
        this.store.getList('schedule');
    },
}
</script>