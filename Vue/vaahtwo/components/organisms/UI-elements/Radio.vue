<template>
  <h5>RadioButton</h5>
  <div class="grid">
    <div class="col-12 md:col-4">
      <div class="field-radiobutton">
        <RadioButton id="option1" name="option" value="Option 1" v-model="radioValue" />
        <label for="option1">Option 1</label>
      </div>
    </div>
    <div class="col-12 md:col-4">
      <div class="field-radiobutton">
        <RadioButton id="option2" name="option" value="Option 2" v-model="radioValue" />
        <label for="option2">Option 2</label>
      </div>
    </div>
    <div class="col-12 md:col-4">
      <div class="field-radiobutton">
        <RadioButton id="option3" name="option" value="Option 3" v-model="radioValue" />
        <label for="option3">Option 3</label>
      </div>
    </div>
    <div class="col-12">
      <h5>Radio Button Small</h5>
      <div class="field-radiobutton">
        <RadioButton inputId="option4" name="option" value="Option 4" v-model="radioValue"  class="is-small"/>
        <label for="city1">Option 4</label>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Radio",
  data(){
    return{
      radioValue: null,
    }
  }
}
</script>

<style scoped>

</style>