<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Box" :code="BoxCode">
        <Box></Box>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Box from "././../../components/Elements/Box/Box";
  import BoxCode from "!raw-loader!././../../components/Elements/Box/Box";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Box',
      }
    },
    computed: {
      BoxCode() {
        return BoxCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Box,
    },
    methods:{
    },

  }
</script>
