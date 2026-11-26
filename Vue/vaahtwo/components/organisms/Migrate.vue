<template>
  <Message severity="info" :closable="true" class="vc-dense">This step will run database migrations and seeds.</Message>
  <Button size="small" label="Migrate & Run Seeds" icon="pi pi-database" iconPos="left" @click="showTemplate" class=""/>
  <div class="flex justify-content-between mt-5">
    <Button size="small" label="Back" class="" @click="goBack"></Button>
    <Button size="small" label="Save & Next" class="" @click="goToNextStep"></Button>
  </div>
  <ConfirmDialog group="templating" class="vc-dense" :style="{width: '400px'}" :breakpoints="{'600px': '100vw'}">
    <template #message="slotProps">
      <div class="flex">
        <i :class="slotProps.message.icon" style="font-size: 1.5rem"></i>
        <p class="pl-2 vc-text-12">{{slotProps.message.message}}</p>
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
        /* UT-104 — the icon carries the scheme-flipping danger-text token
           (light #b91c1c / dark #f87171) instead of the palette literal
           `text-red-600` (`--p-red-600`, scheme-invariant). */
        icon: 'pi pi-exclamation-circle vc-danger-text',
        /* UT-104 — the accept button gets the danger severity as a PROP (the
           F12 pattern) rather than a class string: a class string carries no
           tint through the OpenVue confirm pipeline, `severity: 'danger'`
           does. */
        acceptProps: { severity: 'danger', size: 'small' },
        acceptLabel:'Proceed',
        rejectLabel:'Cancel',
        rejectProps: { size: 'small' },
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
