import { reactive } from 'vue'

export const store = reactive({
  list: [{
    'category': [],
    'account': [],
    'cluster': []
  }],
  update(data) {
    const listIndex = this.getListIndex(data);
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