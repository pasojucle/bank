/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

require('bootstrap');
require('bootstrap-icons/font/bootstrap-icons.css');

import './js/modal';

import { createApp } from 'vue';
import Categories from './components/Categories.vue';
import Clusters from './components/Clusters.vue';
import Accounts from './components/Accounts.vue';
import labels from './components/Labels.vue';
import Transactions from './components/Transactions.vue';

if (document.getElementById('v-categories')) {
    createApp(Categories).mount('#v-categories');
}

if (document.getElementById('v-clusters')) {
    createApp(Clusters).mount('#v-clusters');
}

if (document.getElementById('v-accounts')) {
    createApp(Accounts).mount('#v-accounts');
}

if (document.getElementById('v-labels')) {
    createApp(labels).mount('#v-labels');
}

if (document.getElementById('v-transactions')) {
    createApp(Transactions).mount('#v-transactions');
}

















