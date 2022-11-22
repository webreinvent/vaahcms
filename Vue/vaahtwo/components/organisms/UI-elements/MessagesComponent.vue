<template>
  <h5>Messages</h5>
  <Message severity="info">Info Message</Message>
  <Message severity="success">Success Message</Message>
  <Message severity="warn">Warning Message</Message>
  <Message severity="error">Error Message</Message>
    <h5>Messages Light</h5>
    <Message severity="info" class="is-light">Info Message</Message>
    <Message severity="success" class="is-light">Success Message</Message>
    <Message severity="warn" class="is-light">Warning Message</Message>
    <Message severity="error" class="is-light">Error Message</Message>
</template>

<script>
export default {
  name: "MessagesComponent"
}
</script>

<style scoped>

</style>
