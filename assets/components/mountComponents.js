import { createApp } from 'vue';
import Categories from './Categories.vue';
import Accounts from './Accounts.vue';
import Dashboard from './Dashboard.vue';
import labels from './Labels.vue';
import Transactions from './Transactions.vue';

import SubmitModal from './modal/Submit.vue';
import Datalist from './modal/Datalist.vue';

const mountComponents = () => {
    if (document.getElementById('v-categories')) {
        createApp(Categories).mount('#v-categories');
    }
    
    if (document.getElementById('v-accounts')) {
        createApp(Accounts).mount('#v-accounts');
    }
    
    if (document.getElementById('v-dashboard')) {
        createApp(Dashboard).mount('#v-dashboard');
    }
    
    if (document.getElementById('v-labels')) {
        createApp(labels).mount('#v-labels');
    }
    
    if (document.getElementById('v-transactions')) {
        createApp(Transactions).mount('#v-transactions');
    }
}

const mountModalComponents = () => {   
    if (document.getElementById('v-submit-modal')) {
        createApp(SubmitModal).mount('#v-submit-modal');
    }  
    if (document.querySelector('.v-datalist')) {
        createApp(Datalist).mount('.v-datalist');
    }
}

export { mountComponents, mountModalComponents }