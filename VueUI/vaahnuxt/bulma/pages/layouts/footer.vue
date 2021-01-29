<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Footer" :code="FooterCode">
        <Footer></Footer>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Footer from "./../../components/Layouts/Footer/Footer";
  import FooterCode from "!raw-loader!./../../components/Layouts/Footer/Footer";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Footer',
      }
    },
    computed: {
      FooterCode() {
        return FooterCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Footer,
    },
    methods:{
    },

  }
</script>
