<template>
  <h5>ToggleButton</h5>
  <ToggleButton v-model="toggleValue" onLabel="Yes" offLabel="No"/>
</template>

<script>
export default {
  name: "ToggleButtonComponent",
  data(){
    return{
      toggleValue: false,
    }
  }
}
</script>

<style scoped>

</style>