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
  async getList(entity) {
    await fetch(Routing.generate(`api_${entity}_list`), {
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
  update(data) {
    data.forEach(object => {
      const entity = this.getEntity(object);
      if (undefined !== this.list[entity]) {
        const index = this.list[entity].findIndex(item => {
          return (object.id === item.id)
        })
        this.updateList(object, entity, index);
        this.list[entity].sort(ASC);
      }
    });
    
  },
  updateList(data, entity, index) {
    if (-1 < index) {
      this.list[entity].splice(index, 1, data);
      return;
    }
    this.list[entity].push(data);
  },
  getEntity(data) {
    return data.entityName.split('\\').pop().toLowerCase();
  },
  getDomElement(selector) {
    return document.querySelector(selector);
  },
})

const ASC = (a, b) => {
  const nameA = a.name.toUpperCase();
  const nameB = b.name.toUpperCase();

  return nameA.localeCompare(nameB);
}