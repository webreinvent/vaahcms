<template>
  <h5>Inline Message</h5>
  <div class="formgroup-inline" style="margin-bottom:.5rem">
    <label for="username1" class="p-sr-only">Username</label>
    <InputText id="username1" type="text" placeholder="Username" class="p-invalid mr-2" />
    <InlineMessage>Username is required</InlineMessage>
  </div>
  <div class="formgroup-inline">
    <label for="email" class="p-sr-only">email</label>
    <InputText id="email" placeholder="Email" class="p-invalid mr-2" />
    <InlineMessage />
  </div>
</template>

<script>
export default {
  name: "InlineMessageComponent"
}
</script>

<style scoped>

</style>