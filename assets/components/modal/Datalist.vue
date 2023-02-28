<template>
    <div class="mb-3 datalist-container">
        <label for="{{ select.id }}" class="form-label">{{ select.label }}</label>
        <div class="form-group datalist-container">
            <div id="complete" class="form-control">{{ getSearchName() }}</div>
            <input type="text" class="form-control" v-model="text"/>

        </div>
        <select :id="select.id" :name="select.name" :value="select.value" required v-model="selected" class="form-control hidden">
            <option v-for="label in store.list.label" :value="label.id">{{ label.name }}</option>
        </select>
    </div>

    <!-- <div class="form-group datalist-container">
        <div id="complete" class="form-control">bonjour</div>
        <input type="text" class="form-control" v-model="text"/>
    </div> -->

</template>


<script>

import { store } from './../store.js'



export default {
    data() {
        return {
            el: '',
            text: '',
            search: null,
            value: '',
            select: {},
            store
        }
    },
    methods: {
        getSearchName() {
            if (this.search !== null) {
               return  this.search.name;
            }
            return '';
        }
    },
    watch: {
        text(value) {
            let result = null;
            if (2 < value.length) {
                result = this.store.list.label.filter((element) => {
                    console.log('element', element.name);
                    if (element.name.toLowerCase().includes(value.toLowerCase())) {
                        return element;
                    }
                });
            }
            this.search = (result) ? result.shift() : null;
        },
        choice(value) {
            console.log('watch choice', value);
        }
    },
    created() {
        this.store.getList('label');
        this.el = this.store.getDomElement('.v-datalist');
        this.select = {
            'id': this.el.getAttribute('data-id'),
            'label': this.el.getAttribute('data-label'),
            'value': this.el.getAttribute('data-value'),
            'name': this.el.getAttribute('data-name'),
            'required': this.el.getAttribute('data-required'),
        }

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
        border: none;
    }

</style>