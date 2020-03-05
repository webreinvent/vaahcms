<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Content" :code="ContentsCode">
        <Contents></Contents>
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

  import Contents from "./../../components/Elements/Content/Contents";
  import ContentsCode from "!raw-loader!./../../components/Elements/Content/Contents";

  import Sizes from "./../../components/Elements/Content/Sizes";
  import SizesCode from "!raw-loader!./../../components/Elements/Content/Sizes";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Content',
      }
    },
    computed: {
      ContentsCode() {
        return ContentsCode
      },
      SizesCode() {
        return SizesCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Contents,
      Sizes,
    },
    methods:{
    },

  }
</script>
