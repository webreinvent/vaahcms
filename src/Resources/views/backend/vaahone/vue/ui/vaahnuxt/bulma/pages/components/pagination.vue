<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Pagination" :code="PaginationCode">
        <Pagination></Pagination>
      </SectionCode>


      <SectionCode name="Styles" :code="StylesCode">
        <Styles></Styles>
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

  import Pagination from "./../../components/Components/Pagination/Pagination";
  import PaginationCode from "!raw-loader!./../../components/Components/Pagination/Pagination";

  import Styles from "./../../components/Components/Pagination/Styles";
  import StylesCode from "!raw-loader!./../../components/Components/Pagination/Styles";

  import Sizes from "./../../components/Components/Pagination/Sizes";
  import SizesCode from "!raw-loader!./../../components/Components/Pagination/Sizes";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Pagination',
      }
    },
    computed: {
      PaginationCode() {
        return PaginationCode
      },
      StylesCode() {
        return StylesCode
      },
      SizesCode() {
        return SizesCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Pagination,
      Styles,
      Sizes,
    },
    methods:{
    },

  }
</script>
