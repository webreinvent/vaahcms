<template>
  <h5>Plain Menu</h5>
  <Menu :model="menuitems" />
</template>

<script>
export default {
  name: "PlainMenuComponent",
  data(){
    return{
      menuitems: [
        {
          label:'Customers',
          items:[
            {
              label:'New',
              icon:'pi pi-fw pi-plus',
            },
            {
              label:'Edit',
              icon:'pi pi-fw pi-user-edit'
            }
          ]
        },
        {
          label:'Orders',
          items:[
            {
              label:'View',
              icon:'pi pi-fw pi-list'
            },
            {
              label:'Search',
              icon:'pi pi-fw pi-search'
            },

          ]
        }
      ]
    }
  }
}
</script>

<style scoped>

</style>