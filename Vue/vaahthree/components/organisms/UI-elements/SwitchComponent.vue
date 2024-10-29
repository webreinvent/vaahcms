<template>
  <h5>Input Switch</h5>
  <InputSwitch v-model="switchValue" />

  <h5>Switch Small</h5>
  <InputSwitch v-model="switchValue" class="is-small"/>
</template>

<script>
export default {
  name: "SwitchComponent",
  data(){
    return{
      switchValue:false
    }
  }
}
</script>

<style scoped>

</style>