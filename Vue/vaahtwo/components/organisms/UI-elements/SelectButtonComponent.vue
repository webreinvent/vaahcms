<template>
  <h5>SelectButton</h5>
  <SelectButton v-model="selectButtonValue1" :options="selectButtonValues1" optionLabel="name" />
</template>

<script>
export default {
  name: "SelectButtonComponent",
  data(){
    return{
      selectButtonValues1: [
        {name: 'Option 1', code: 'O1'},
        {name: 'Option 2', code: 'O2'},
        {name: 'Option 3', code: 'O3'},
      ],
      selectButtonValue1: null,
    }
  }
}
</script>

<style scoped>

</style>