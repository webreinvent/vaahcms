<template>
  <h5>Helper Text</h5>
  <Fluid class="field">
    <label for="username2">Username</label>
    <InputText id="username2" type="text" aria-describedby="username-help" />
    <small id="username-help" class="p-error">Enter your username to reset your password.</small>
  </Fluid>
</template>

<script>
export default {
  name: "HelperTextComponent"
}
</script>

<style scoped>

</style>