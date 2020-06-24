<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Tiles" :code="TilesCode">
        <Tiles></Tiles>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Tiles from "./../../components/Layouts/Tiles/Tiles";
  import TilesCode from "!raw-loader!./../../components/Layouts/Tiles/Tiles";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Tiles',
      }
    },
    computed: {
      TilesCode() {
        return TilesCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Tiles,
    },
    methods:{
    },

  }
</script>
