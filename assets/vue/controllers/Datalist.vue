<template>
    <div class="mb-3 datalist-container">
        <label for="{{ formId }}" class="form-label">{{ formLabel }}</label>
        <div class="form-group datalist-container">
            <div id="complete" class="form-control">{{ getSearchName() }}</div>
            <input type="text" :class="classComplete" v-model="input" @keydown.enter.prevent="complete($event)"/>

        </div>
        <select :id="formId" :name="formName" required v-model="label.id" class="form-control hidden">
            <option v-for="(option, index) in options" :key="index" :value="option.id" :selected="option.id == label.id">{{ option.name }}</option>
        </select>
    </div>
</template>

<script>

import { store } from './store.js'
import Routing from 'fos-router';

export default {
    props: {
        formId: String,
        formLabel:  String,
        formName: String,
        initialValue: Object,
    },
    data() {
        return {
            el: '',
            classComplete: 'form-control',
            input: '',
            search: null,
            labelText: '',
            label: {},
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
            console.log('complete input', this.input);
        },
        refresh(value) {
            console.log('[refresh]', value)
            if (this.search && value === this.search.name) {
                this.classComplete = 'form-control complete';
                console.log('search', this.search);
                this.label = this.search;
                this.getDefaultCategory();
               return;
            }

            this.classComplete = 'form-control';
            let index =  this.options.findIndex(({ id }) => id.toString().startsWith('__'));
            const id = '__'+value;
            this.label = {'id': id, 'name': value}
            this.options[index] = this.label;
        },
        async getDefaultCategory() {
            await fetch(Routing.generate(`json_category_default`, {'label': this.search.id}), {
                method: "GET", 
              })
            .then(response => response.json())
            .then(data => {
                console.log('data', data);
                if (data.category) {
                   document.querySelector('[name ="transaction[category]"], [name ="deadline[category]"]').value = data.category.id;
                }
            });
        }
    },
    watch: {
        input(value) {
            let result = [];
            console.log('labels', this.store.list.label)
            console.log('watch', value)
            if (undefined === value) {
                return;
            }
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
            console.log('this.label', this.label)
            console.log('result', result)

            this.search = (0 < result.length && (1 > this.label.name || result.length <= this.label.name.length)) ? result.shift() : null;
            console.log('search', this.search)
            this.refresh(value);
        },
    },
    created() {
        console.log('created', this)
        this.store.getList('label').then(() => {
            this.setOptions();
            this.label = this.initialValue;
            this.input = this.label.name;
            console.log('input', this.input)
        });
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