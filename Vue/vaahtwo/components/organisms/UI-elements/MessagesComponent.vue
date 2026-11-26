<template>
  <h5>Messages</h5>
  <Message severity="info">Info Message</Message>
  <Message severity="success">Success Message</Message>
  <Message severity="warn">Warning Message</Message>
  <Message severity="error">Error Message</Message>
  <!-- M7-T4 — the v3 "Messages Light" section is removed: `is-light` has no
       v4 engine equivalent, so the section rendered byte-identical to the
       block above it (dead duplicate demo content). -->
</template>

<script>
export default {
  name: "MessagesComponent"
}
</script>

<style scoped>

</style>
