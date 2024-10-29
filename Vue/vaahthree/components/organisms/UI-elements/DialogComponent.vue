<template>
  <h5>Dialog</h5>
  <Dialog header="Dialog" v-model:visible="display" :style="{width: '30vw'}" :modal="true">
    <p>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit
      in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
      Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </p>
    <template #footer>
      <Button label="Dismiss" @click="close" icon="pi pi-check" class="p-button-text"/>
    </template>
  </Dialog>
  <Button label="Show" icon="pi pi-external-link" @click="open" class="p-button-secondary"/>
</template>

<script>
export default {
  name: "DialogComponent",
  data(){
    return{
      display: false,
    }
  },
  methods:{
    close() {
      this.display = false;
    },
    open() {
      this.display = true;
    },
  }
}
</script>

<style scoped>

</style>