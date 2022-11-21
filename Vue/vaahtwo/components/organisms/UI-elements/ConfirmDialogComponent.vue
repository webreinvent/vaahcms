<template>
  <h5>Confirm Dialog</h5>
  <Button type="button" label="Confirm" @click="confirmWithDialog" class="p-button-help" icon="pi pi-check" />
  <ConfirmDialog group="dialog">></ConfirmDialog>
</template>

<script>
export default {
  name: "ConfirmDialogComponent",
  methods:{
    confirmWithDialog() {
      this.$confirm.require({
        group: 'dialog',
        header: 'Confirm',
        message: 'Are you sure you want to proceed?',
        icon: 'pi pi-exclamation-triangle',
        accept: () => {
          this.$toast.add({severity:'info', summary:'Confirmed', detail:'You have accepted', life: 3000});
        },
        reject: () => {
          this.$toast.add({severity:'info', summary:'Rejected', detail:'You have rejected', life: 3000});
        }
      });
    },
  }
}
</script>

<style scoped>

</style>