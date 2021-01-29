<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Media Object" :code="MediaObjectCode">
        <MediaObject></MediaObject>
      </SectionCode>


      <SectionCode name="Nesting" :code="NestingCode">
        <Nesting></Nesting>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import MediaObject from "./../../components/Layouts/MediaObject/MediaObject";
  import MediaObjectCode from "!raw-loader!./../../components/Layouts/MediaObject/MediaObject";

  import Nesting from "./../../components/Layouts/MediaObject/Nesting";
  import NestingCode from "!raw-loader!./../../components/Layouts/MediaObject/Nesting";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Media Object',
      }
    },
    computed: {
      MediaObjectCode() {
        return MediaObjectCode
      },
      NestingCode() {
        return NestingCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      MediaObject,
      Nesting,
    },
    methods:{
    },

  }
</script>
