<template>
  <div class="p-fluid">
    <!----- Input Text States Start ----->
    <h5 id="inputText">Input Text</h5>
    <div class="grid fprmgrid flex-column">
      <div class="col-12 mb-2 lg:col-4 lg:mb-0">
        <InputText type="text" placeholder="Default"></InputText>
      </div>
      <div class="col-12 mb-2 lg:col-4 lg:mb-0">
        <InputText type="text" placeholder="Disabled" :disabled="true"></InputText>
      </div>
      <div class="col-12 mb-2 lg:col-4 lg:mb-0">
        <InputText type="text" placeholder="Invalid" class="p-invalid" />
      </div>
    </div>
    <!----- Input Text States End ----->


    <!----- Input Text Sizes Start ----->
    <h5 id="inputTextSize">Input Text Sizes</h5>
    <div class="grid fprmgrid flex-column">
      <div class="col-12 mb-2 lg:col-4 lg:mb-0">
        <InputText type="text" placeholder="Small" class="p-inputtext-sm"></InputText>
      </div>
      <div class="col-12 mb-2 lg:col-4 lg:mb-0">
        <InputText type="text" placeholder="Default"></InputText>
      </div>
      <div class="col-12 mb-2 lg:col-4 lg:mb-0">
        <InputText type="text" placeholder="Large" class="p-inputtext-lg"></InputText>
      </div>
    </div>
    <!----- Input Text Sizes End ----->


    <!----- Input Text with Icons Start ----->
    <h5>Icons</h5>
    <div class="grid fprmgrid flex-column">
      <div class="col-12 mb-2 lg:col-4 lg:mb-0">
			  <span class="p-input-icon-left">
				  <i class="pi pi-user"/>
          <InputText type="text" placeholder="Username" />
        </span>
      </div>
      <div class="col-12 mb-2 lg:col-4 lg:mb-0">
        <span class="p-input-icon-right">
				  <InputText type="text" placeholder="Search" />
					<i class="pi pi-search"/>
        </span>
      </div>
      <div class="col-12 mb-2 lg:col-4 lg:mb-0">
        <span class="p-input-icon-left p-input-icon-right">
          <i class="pi pi-user" />
					<InputText type="text" placeholder="Search" />
					<i class="pi pi-search" />
        </span>
      </div>
    </div>
    <!----- Input Text with Icons End ----->


    <!----- Input Text with Floating label Start ----->
    <h5>Float Label</h5>
    <span class="p-float-label">
				<InputText id="username" type="text" v-model="floatValue"/>
				<label for="username">Username</label>
    </span>
    <!----- Input Text with Floating label End ----->


      <!-----Text Area Start----->
    <h5>Textarea</h5>
    <Textarea placeholder="Your Message" :autoResize="true" rows="3" cols="30" />
      <!-----Text Area End----->


    <!----- AutoComplete Star ----->
    <h5>AutoComplete</h5>
    <AutoComplete placeholder="Search" id="dd" :dropdown="true" :multiple="true" v-model="selectedAutoValue" :suggestions="autoFilteredValue" @complete="searchCountry($event)" field="name"/>
    <!----- AutoComplete End ----->


    <!----- Calendar Start ----->
    <h5>Calendar</h5>
    <Calendar :showIcon="true" :showButtonBar="true" v-model="calendarValue"></Calendar>
    <!----- Calendar End ----->


    <!----- Spinner Start ----->
    <h5>Spinner</h5>
    <InputNumber v-model="inputNumberValue" showButtons mode="decimal"></InputNumber>
    <!----- Spinner End ----->


    <!----- Chips Start ----->
    <h5>Chips</h5>
    <Chips v-model="chipsValue" class="w-full" inputClass="w-full"/>


    <h5>Chips Small</h5>
    <Chips v-model="chipsValue" class="is-small w-full" inputClass="w-full"/>
    <!----- Chips End ----->


    <!----- Slider Start ----->
    <h5>Slider</h5>
    <InputText v-model.number="sliderValue" class="mb-3"/>
    <Slider v-model="sliderValue" />
    <!----- Slider End ----->


    <!----- Rating Start ----->
    <h5>Rating</h5>
    <Rating v-model="ratingValue"/>
    <!----- Rating End ----->


  </div>



</template>

<script>
export default {
  name: "Input",
  data(){
    return{
      floatValue: null,
      selectedAutoValue: null,
      autoFilteredValue: [],
      calendarValue: null,
      inputNumberValue: null,
      chipsValue: null,
      sliderValue: null,
      ratingValue: null,
      switchValue: false,
      checked1:false
    }
  },
  methods:{
    searchCountry(event) {
      setTimeout(() => {
        if (!event.query.trim().length) {
          this.autoFilteredValue = [...this.autoValue];
        }
        else {
          this.autoFilteredValue = this.autoValue.filter((country) => {
            return country.name.toLowerCase().startsWith(event.query.toLowerCase());
          });
        }
      }, 250);
    }
  }
}
</script>

<style scoped>

</style>