<template>
  <h5>SelectButton - Multiple</h5>
  <SelectButton v-model="selectButtonValue2" :options="selectButtonValues2" optionLabel="name" :multiple="true"/>
</template>

<script>
export default {
  name: "MultilipleSelectButtonComponent",
  data(){
    return{
      selectButtonValues2: [
        {name: 'Option 1', code: 'O1'},
        {name: 'Option 2', code: 'O2'},
        {name: 'Option 3', code: 'O3'},
      ],
      selectButtonValue2: null,
    }
  }
}
</script>

<style scoped>

</style>