<template>
  <h5>Listbox</h5>
  <Listbox v-model="listboxValue" :options="listboxValues" optionLabel="name" :filter="true"/>
</template>

<script>
export default {
  name: "ListboxComponent",
  data(){
    return{
      listboxValues: [
        {name: 'New York', code: 'NY'},
        {name: 'Rome', code: 'RM'},
        {name: 'London', code: 'LDN'},
        {name: 'Istanbul', code: 'IST'},
        {name: 'Paris', code: 'PRS'}
      ],
      listboxValue: null,
    }
  }
}
</script>

<style scoped>

</style>