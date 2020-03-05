<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Checkbox" :code="CheckboxCode">
        <Checkbox></Checkbox>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Checkbox from "./../../components/Forms/Checkbox/Checkbox";
  import CheckboxCode from "!raw-loader!./../../components/Forms/Checkbox/Checkbox";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Checkbox',
      }
    },
    computed: {
      CheckboxCode() {
        return CheckboxCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Checkbox,
    },
    methods:{
    },

  }
</script>
