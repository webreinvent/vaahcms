<template>
  <h5>Toast</h5>

  <Toast />
  <Button @click="showToast('info')" label="Info" class="p-button-info mr-2 mb-2" />
  <Button @click="showToast('success')" label="Success" class="p-button-success mr-2 mb-2" />
  <Button @click="showToast('warn')" label="Warn" class="p-button-warning mr-2 mb-2" />
  <Button @click="showToast('error')" label="Error" class="p-button-danger mb-2" />
</template>

<script>
export default {
  name: "ToastsComponent",
  methods:{
    showToast(severity) {
      this.$toast.add({severity: severity, summary: 'Message Summary', detail:'Message Detail', life: 3000});
    },
  }
}
</script>

<style scoped>

</style>