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
  async getList(entity) {
    await fetch(Routing.generate(`api_${entity}_list`), {"method": "GET"})
    .then(response => response.json())
    .then(data => {
        this.list[entity] = data.list;
    });
},
  update(data) {
    console.log('data', data);
    const entity = this.getEntity(data);
    console.log('entity', entity);
    console.log('lists', this.list);
    console.log('list', this.list[entity]);
    const index = this.list[entity].findIndex(item => {
      return (data.id === item.id)
    })
    this.updateList(data, entity, index);
    this.list[entity].sort(ASC);
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
  }
})

const ASC = (a, b) => {
  const nameA = a.name.toUpperCase();
  const nameB = b.name.toUpperCase();

  return nameA.localeCompare(nameB);
}