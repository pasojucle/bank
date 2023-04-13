import { createApp } from 'vue';
import Categories from './Categories.vue';
import Account from './Account.vue';
import Accounts from './Accounts.vue';
import Dashboard from './Dashboard.vue';
import Labels from './Labels.vue';
import SearchFilter from './SearchFilter.vue';
import Transactions from './Transactions.vue';
import TransactionsFilter from './TransactionsFilter.vue';

import SubmitModal from './modal/Submit.vue';
import Datalist from './modal/Datalist.vue';

const mountComponents = () => {
    if (document.getElementById('v-categories')) {
        createApp(Categories).mount('#v-categories');
    }
    
    if (document.getElementById('v-account')) {
        createApp(Account).mount('#v-account');
    }
    
    if (document.getElementById('v-accounts')) {
        createApp(Accounts).mount('#v-accounts');
    }
    
    if (document.getElementById('v-dashboard')) {
        createApp(Dashboard).mount('#v-dashboard');
    }
    
    if (document.getElementById('v-labels')) {
        createApp(Labels).mount('#v-labels');
    }
    if (document.getElementById('v-search-filter')) {
        createApp(SearchFilter).mount('#v-search-filter');
    }
    
    if (document.getElementById('v-transactions')) {
        createApp(Transactions).mount('#v-transactions');
    }
    
    if (document.getElementById('v-transactions-filter')) {
        createApp(TransactionsFilter).mount('#v-transactions-filter');
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