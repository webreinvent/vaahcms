<template>
  <h5>Checkbox</h5>
  <div class="grid">
    <div class="col-12 md:col-4">
      <div class="field-checkbox">
        <Checkbox id="checkOption1" name="option" value="Option 1" v-model="checkboxValue" />
        <label for="checkOption1">Option 1</label>
      </div>
    </div>
    <div class="col-12 md:col-4">
      <div class="field-checkbox">
        <Checkbox id="checkOption2" name="option" value="Option 2" v-model="checkboxValue" />
        <label for="checkOption2">Option 2</label>
      </div>
    </div>
    <div class="col-12 md:col-4">
      <div class="field-checkbox">
        <Checkbox id="checkOption3" name="option" value="Option 3" v-model="checkboxValue" />
        <label for="checkOption3">Option 3</label>
      </div>
    </div>
    <div class="col-12">
      <h5>Checkbox Small</h5>
      <div class="field-checkbox">
        <Checkbox inputId="checkOption4" v-model="checkboxValue" value="Option 4" class="is-small" />
        <label for="checkOption4">Option 4</label>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CheckboxComponent",
  data(){
    return{
      checkboxValue: [],
    }
  }
}
</script>

<style scoped>

</style>