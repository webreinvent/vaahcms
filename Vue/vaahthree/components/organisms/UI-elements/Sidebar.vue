<template>
  <div class="sidebar">
    <Menu :model="items">
      <template #item="{item}">
        <a href="#inputText" class="p-menuitem-link capitalize">{{item.label}}</a>
      </template>
    </Menu>
  </div>
</template>

<script>
export default {
  name: "Sidebar",
  data(){
    return{
      items: [
        {
          label: 'colors'
        },
        {
          label: 'input'
        }
      ]
    }
  }
}
</script>

<style scoped>

</style>