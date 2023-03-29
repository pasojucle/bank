import { reactive } from 'vue'
const routes = require('../../web/js/fos_js_routes.json');

import Routing from 'fos-router';


export const store = reactive({
  list: [{
    'account': [],
    'category': [],
    'cluster': [],
    'label': [],
    'transaction': [],
  }],
  getAuthToken() {
    const authToken = document.querySelector('div[data-bearer]');
    return "Bearer " + authToken.dataset.bearer;
  },
  async getList(entity, params = {}) {
    await fetch(Routing.generate(`api_${entity}_list`, params), {
      method: "GET", 
      headers: {
        "Authorization": this.getAuthToken(),
    }})
    .then(response => response.json())
    .then(data => {
        this.list[entity] = data.list;
        console.log('list', this.list[entity])
    });
  },
  async edit(entity, params = {}) {
    await fetch(Routing.generate(`api_${entity}_edit`, params), {
      method: "GET", 
      headers: {
        "Authorization": this.getAuthToken(),
    }})
    .then(response => response.json())
    .then(data => {
        this.update(data);
        console.log('list', this.list[entity])
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
      this.updateList(object.value, object.entity, index);
      this.list[object.entity].sort(this[object.sort]);
    }
  },
  updateList(data, entity, index) {
    if (-1 < index) {
      this.list[entity].splice(index, 1, data);
      return;
    }
    this.list[entity].push(data);
  },
  // getEntity(data) {
  //   return data.entityName.split('\\').pop().toLowerCase();
  // },
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

