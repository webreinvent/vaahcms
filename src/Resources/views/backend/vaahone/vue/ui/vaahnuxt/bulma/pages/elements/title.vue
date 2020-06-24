<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="TitleAndSubtitle" :code="TitleAndSubtitleCode">
        <TitleAndSubtitle></TitleAndSubtitle>
      </SectionCode>


      <SectionCode name="Sizes" :code="SizesCode">
        <Sizes></Sizes>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import TitleAndSubtitle from "./../../components/Elements/Title/TitleAndSubtitle";
  import TitleAndSubtitleCode from "!raw-loader!./../../components/Elements/Title/TitleAndSubtitle";

  import Sizes from "./../../components/Elements/Title/Sizes";
  import SizesCode from "!raw-loader!./../../components/Elements/Title/Sizes";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Title',
      }
    },
    computed: {
      TitleAndSubtitleCode() {
        return TitleAndSubtitleCode
      },
      SizesCode() {
        return SizesCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      TitleAndSubtitle,
      Sizes,
    },
    methods:{
    },

  }
</script>
