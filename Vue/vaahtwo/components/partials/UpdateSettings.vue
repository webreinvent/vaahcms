<template>
<Card>
  <template #header>
    <div class="pt-3 px-4 flex justify-content-between align-items-center">
      <h5 class="font-semibold text-lg white-space-nowrap">Update VaahCMS</h5>
      <div class="p-inputgroup justify-content-end">
        <Button icon="pi pi-refresh" label="Check for Update"></Button>
      </div>
    </div>
  </template>
  <template #content>
    <div class="text-center">
        <h4>Current Version of</h4>
        <p><Tag>VaahCMS</Tag> is <Tag>v1.6.10</Tag></p>
    </div>
  </template>
</Card>
</template>

<script>
export default {
  name: "UpdateSettings"
}
</script>

<style scoped>

</style>