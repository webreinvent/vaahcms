<template>
  <div @contextmenu="onContextRightClick">
    <h5>ContextMenu</h5>
    Right click to display.
    <ContextMenu ref="contextMenu" :model="contextMenuItems" />
  </div>
</template>

<script>
export default {
  name: "ContextMenuComponent",
  data(){
    return{
      contextMenuItems: [
        {
          label: 'Save',
          icon: 'pi pi-save'
        },
        {
          label: 'Update',
          icon: 'pi pi-refresh'
        },
        {
          label: 'Delete',
          icon: 'pi pi-trash'
        },
        {
          separator: true
        },
        {
          label: 'Options',
          icon: 'pi pi-cog'
        },
      ],
    }
  },
  methods:{
    onContextRightClick(event) {
      this.$refs.contextMenu.show(event);
    },
  }
}
</script>

<style scoped>

</style>