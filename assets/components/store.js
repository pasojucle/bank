import { reactive } from 'vue'

export const store = reactive({
  list: [{
    'categories': [],
    'account': [],
  }],
  update(data, listIndex) {
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
  }
})

const ASC = (a, b) => {
  const nameA = a.name.toUpperCase();
  const nameB = b.name.toUpperCase();
  if (nameA < nameB) {
    return -1;
  }
  if (nameA > nameB) {
    return 1;
  }
  return 0;
}