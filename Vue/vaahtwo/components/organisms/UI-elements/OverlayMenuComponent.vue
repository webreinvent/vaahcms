<template>
  <h5>Overlay Menu</h5>
  <Menu ref="menu" :model="menuitems" :popup="true" />
  <Button type="button" label="Options" icon="pi pi-angle-down" @click="toggleMenu" style="width: auto"/>
</template>

<script>
export default {
  name: "OverlayMenuComponent",
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
  },
  methods:{
    toggleMenu(event) {
      this.$refs.menu.toggle(event);
    },
  }
}
</script>

<style scoped>

</style>