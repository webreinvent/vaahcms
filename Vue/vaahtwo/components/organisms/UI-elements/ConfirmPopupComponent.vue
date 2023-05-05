<template>
  <h5>Confirm Popup</h5>
  <Button type="button" label="Confirm" @click="confirmWithPopup" class="p-button-success" icon="pi pi-check" />
  <ConfirmPopup group="popup"></ConfirmPopup>
</template>

<script>
export default {
  name: "ConfirmPopupComponent",
  methods:{
    confirmWithPopup(event) {
      this.$confirm.require({
        target: event.currentTarget,
        group: 'popup',
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