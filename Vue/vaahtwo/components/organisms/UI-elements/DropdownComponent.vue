<template>
  <h5>Dropdown</h5>
  <Dropdown v-model="dropdownValue" :options="dropdownValues" optionLabel="name" placeholder="Select" />
</template>

<script>
export default {
  name: "DropdownComponent",
  data(){
    return{
      dropdownValues: [
        {name: 'New York', code: 'NY'},
        {name: 'Rome', code: 'RM'},
        {name: 'London', code: 'LDN'},
        {name: 'Istanbul', code: 'IST'},
        {name: 'Paris', code: 'PRS'}
      ],
      dropdownValue: null,
    }
  }
}
</script>

<style scoped>

</style>