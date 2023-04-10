import { reactive } from 'vue'
const routes = require('../../web/js/fos_js_routes.json');

import Routing from 'fos-router';


export const store = reactive({
  list: {
    'account': [],
    'category': [],
    'cluster': [],
    'label': [],
    'transaction': [],
  },
  needle: null,
  async getList(entity, params = {}) {
    await fetch(Routing.generate(`json_${entity}_list`, params), {
      method: "GET", 
    })
    .then(response => response.json())
    .then(data => {
        this.list[entity] = data.list;
        console.log('list', this.list[entity])
    });
  },
  async edit(entity, params = {}) {
    await fetch(Routing.generate(`json_${entity}_edit`, params), {
      method: "GET", 
    })
    .then(response => response.json())
    .then(data => {
        this.update(data);
        console.log('list', this.list[entity])
    });
  },
  async checkTransaction(id) {
    await fetch(Routing.generate('transaction_check', {'id': id}), {
      method: "GET", 
    })
    .then(response => response.json())
    .then(data => {
        console.log('checkTransaction response', data);
        this.updateAll(data);
    });
  },
  updateAll(data) {
    data.forEach((object) => {
        this.update(object);
    });
  },
  update(object) {
    if (undefined !== this.list[object.entity]) {
      const index = this.list[object.entity].findIndex(item => {
        return (object.value.id === item.id)
      })
      if (-1 !== index) {
        this.updateList(object.value, object.entity, index);
        this.list[object.entity].sort(this[object.sort]);
        return;
      }
      this.list[object.entity].push(object.value);
      this.list[object.entity].sort(this[object.sort]);
    }
    console.log('update list', this.list)
  },
  updateList(data, entity, index) {
    if (-1 < index) {
      this.list[entity].splice(index, 1, data);
      return;
    }
    this.list[entity].push(data);
  },
  listFindById(entity, entityId) {
    console.log('listFindById', entityId, this.list[entity])
    return this.list[entity].find(({id}) => id === parseInt(entityId));
  },
  listFiltered(entity) {
    if (null === this.needle) {
      console.log('list filtered', this.list[entity]);
      return this.list[entity];
    }
    return this.list[entity].filter(item => item.label.name.toLowerCase().includes(this.needle.toLowerCase()) || item.amount.includes(this.needle) || item.createdAtStr.includes(this.needle) );
  },
  getDomElement(selector) {
    return document.querySelector(selector);
  },
  nameASC(a, b) {
    const nameA = a.name.toUpperCase();
    const nameB = b.name.toUpperCase();
  
    return nameA.localeCompare(nameB);
  },
  createdAtDESC(a, b) {
    const createdAtA = a.createdAt;
    const createdAtB = b.createdAt;
  
    return createdAtB.localeCompare(createdAtA);
  }
})

