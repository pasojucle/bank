<template>
    <div class="mb-3 datalist-container">
        <label for="{{ select.id }}" class="form-label">{{ selectedLabel.label }}</label>
        <div class="form-group datalist-container">
            <div id="complete" class="form-control">{{ getSearchName() }}</div>
            <input type="text" :class="classComplete" v-model="input" @keydown.enter.prevent="complete($event)"/>

        </div>
        <select :id="selectedLabel.id" :name="selectedLabel.name" required v-model="selectedLabel.value" class="form-control hidden">
            <option v-for="(option, index) in options" :key="index" :value="option.id" :selected="option.id == selectedLabel.value">{{ option.name }}</option>
        </select>
    </div>
</template>

<script>

import { store } from './../store.js'
import Routing from 'fos-router';

export default {
    data() {
        return {
            el: '',
            classComplete: 'form-control',
            input: '',
            search: null,
            value: '',
            selectedLabel: {},
            options: [],
            store
        }
    },
    methods: {
        setOptions() {
            this.options =  [...this.store.list.label];
            this.options.push({'id': '__', 'label': ''});
        },
        getSearchName() {
            if (this.search !== null) {
               return  this.search.name;
            }
            return '';
        },
        capitalize(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
        complete() {
            if (0 < this.search.id) {
                this.input = this.search.name;
            }
        },
        refresh(value) {
            if (this.search && value === this.search.name) {
                this.classComplete = 'form-control complete';
                this.selectedLabel.value = this.search.id;
                this.getDefaultCategory();
               return;
            }
            this.selectedLabel.value = null;
            this.classComplete = 'form-control';
            let index =  this.options.findIndex(({ id }) => id.toString().startsWith('__'));
            const id = '__'+value;
            this.options[index] = {'id': id, 'label': value};
            this.selectedLabel.value = id;
        },
        async getDefaultCategory() {
            await fetch(Routing.generate(`api_category_default`, {'label': this.search.id}), {
                method: "GET", 
                headers: {
                    "Authorization": this.store.getAuthToken(),
            }})
            .then(response => response.json())
            .then(data => {
                if (data.category) {
                   document.querySelector('[name ="transaction[category]"]').value = data.category.id;
                }
            });
        }
    },
    watch: {
        input(value) {
            let result = [];
            console.log('labels', this.store.list.label)
            if (0 < value.length) {
                this.input = this.capitalize(value);
            }
            if (2 < value.length) {
                result = this.store.list.label.filter((element) => {
                    if (element.name.toLowerCase().includes(value.toLowerCase())) {
                        return element;
                    }
                });
            }

            this.search = (0 < result.length && (1 > this.selectedLabel.value || result.length <= this.selectedLabel.value.length)) ? result.shift() : null;
            this.refresh(value);
            console.log('[selectedLabel]', this.selectedLabel)
        },
    },
    created() {
        this.store.getList('label').then(() => {
            this.setOptions();
        });
        this.el = this.store.getDomElement('.v-datalist');
        this.selectedLabel = {
            'id': this.el.getAttribute('data-id'),
            'label': this.el.getAttribute('data-label'),
            'value': this.el.getAttribute('data-value'),
            'name': this.el.getAttribute('data-name'),
            'required': this.el.getAttribute('data-required'),
        };
    },
}
</script>

<style scoped>
    .datalist-container {
        position: relative;
    }
    .datalist-container .form-group .form-control {
        position: absolute;
        cursor: text;
    }
    .datalist-container .form-group .form-control:focus,
    .datalist-container .form-group .form-control:focus{
        outline: none;
        border-color: #aaa;
    }
    .datalist-container .form-group input {
        color: #333;
        background-color: transparent;
    }
    .datalist-container .form-group #complete {
        color: #999;
        border: 1px solid transparent;
    }
    .datalist-container .form-group .complete {
        color: #0d6efd;
    }

</style>