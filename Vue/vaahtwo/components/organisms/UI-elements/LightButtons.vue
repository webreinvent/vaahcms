<template>
  <div>
    <h5>Light Buttons</h5>
    <!-- M7-T4 — the v3 `is-light` modifier row is the v4 `variant="outlined"`
         row: same severity per label, tint carried by PROP (F12), not by a
         `p-button-*` class string. The `Plain` row takes the `contrast`
         severity — v4's replacement for the deprecated `plain` boolean. -->
    <Button label="Primary" variant="outlined" class="mr-2 mb-2"/>
    <Button label="Secondary" severity="secondary" variant="outlined" class="mr-2 mb-2" />
    <Button label="Success" severity="success" variant="outlined" class="mr-2 mb-2" />
    <Button label="Info" severity="info" variant="outlined" class="mr-2 mb-2" />
    <Button label="Warning" severity="warn" variant="outlined" class="mr-2 mb-2" />
    <Button label="Help" severity="help" variant="outlined" class="mr-2 mb-2" />
    <Button label="Danger" severity="danger" variant="outlined" class="mr-2 mb-2" />
    <Button label="Plain" severity="contrast" class="mb-2" />
  </div>
</template>

<script>
export default {
  name: "LightButtons"
}
</script>

<style scoped>

</style>