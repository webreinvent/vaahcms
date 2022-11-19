<template>
  <Message severity="info" :closable="true" class="is-small">This step will run database migrations and seeds.</Message>
  <Button label="Migrate & Run Seeds" icon="pi pi-database" iconPos="left" @click="showTemplate" class="p-button-sm"/>
  <div class="flex justify-content-between mt-5">
    <Button label="Back" class="p-button-sm" @click="goBack"></Button>
    <Button label="Save & Next" class="p-button-sm" @click="goToNextStep"></Button>
  </div>
  <ConfirmDialog group="templating" class="is-small" :style="{width: '400px'}" :breakpoints="{'600px': '100vw'}">
    <template #message="slotProps">
      <div class="flex">
        <i :class="slotProps.message.icon" style="font-size: 1.5rem"></i>
        <p class="pl-2 text-xs">{{slotProps.message.message}}</p>
      </div>
    </template>
  </ConfirmDialog>
</template>

<script>
export default {
  name: "Migrate",
  methods: {
    goBack(){
      this.$router.push("/ui/public/install/configuration")
    },
    goToNextStep(){
      this.$router.push("/ui/public/install/dependencies")
    },
    showTemplate() {
      console.log('test'),
      this.$confirm.require({
        group: 'templating',
        header: 'Deleting existing migrations',
        message: 'This will delete all existing migration from database/migrations folder.',
        icon: 'pi pi-exclamation-circle text-red-600',
        acceptClass:'p-button p-button-danger p-button-sm',
        acceptLabel:'Proceed',
        rejectLabel:'Cancel',
        rejectClass:'p-button-sm',
        accept: () => {
          console.log('accepted')
        },
        reject: () => {
          console.log('rejected')
        },
        onHide: () => {
          this.$toast.add({severity:'error', summary:'Hide', detail:'You have hidden', life: 3000});
        }
      });
    }
  }
}
</script>

<style scoped>

</style>
