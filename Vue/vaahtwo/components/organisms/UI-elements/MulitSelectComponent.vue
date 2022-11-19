<template>
  <h5>MultiSelect</h5>
  <MultiSelect v-model="multiselectValue" :options="multiselectValues" optionLabel="name" placeholder="Select Countries" :filter="true"></MultiSelect>
</template>

<script>
export default {
  name: "MulitSelectComponent",
  data(){
    return{
      multiselectValue: null,
      multiselectValues: [
        {name: 'Australia', code: 'AU'},
        {name: 'Brazil', code: 'BR'},
        {name: 'China', code: 'CN'},
        {name: 'Egypt', code: 'EG'},
        {name: 'France', code: 'FR'},
        {name: 'Germany', code: 'DE'},
        {name: 'India', code: 'IN'},
        {name: 'Japan', code: 'JP'},
        {name: 'Spain', code: 'ES'},
        {name: 'United States', code: 'US'}
      ],
    }
  }
}
</script>

<style scoped>

</style>