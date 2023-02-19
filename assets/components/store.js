import { reactive } from 'vue'

export const store = reactive({
  list: [{
    'account': [],
    'category': [],
    'cluster': [],
    'label': [],
    'transaction': [],
  }],
  update(data) {
    console.log('data', data);
    const listIndex = this.getListIndex(data);
    console.log('listIndex', listIndex);
    console.log('lists', this.list);
    console.log('list', this.list[listIndex]);
    const index = this.list[listIndex].findIndex(item => {
      return (data.id === item.id)
    })
    this.updateList(data, listIndex, index);
    this.list[listIndex].sort(ASC);
  },
  updateList(data, listIndex, index) {
    if (-1 < index) {
      this.list[listIndex].splice(index, 1, data);
      return;
    }
    this.list[listIndex].push(data);
  },
  getListIndex(data) {
    return data.entityName.split('\\').pop().toLowerCase();
  }
})

const ASC = (a, b) => {
  const nameA = a.name.toUpperCase();
  const nameB = b.name.toUpperCase();

  return nameA.localeCompare(nameB);
}