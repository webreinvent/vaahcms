<template>
  <h5>Helper Text</h5>
  <div class="field p-fluid">
    <label for="username2">Username</label>
    <InputText id="username2" type="text" aria-describedby="username-help" />
    <small id="username-help" class="p-error">Enter your username to reset your password.</small>
  </div>
</template>

<script>
export default {
  name: "HelperTextComponent"
}
</script>

<style scoped>

</style>