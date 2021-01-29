<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Progress Bar" :code="ProgressBarCode">
        <ProgressBar></ProgressBar>
      </SectionCode>


      <SectionCode name="Colors" :code="ColorsCode">
        <Colors></Colors>
      </SectionCode>


      <SectionCode name="Sizes" :code="SizesCode">
        <Sizes></Sizes>
      </SectionCode>


      <SectionCode name="Indeterminate" :code="IndeterminateCode">
        <Indeterminate></Indeterminate>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import ProgressBar from "./../../components/Elements/ProgressBar/ProgressBar";
  import ProgressBarCode from "!raw-loader!./../../components/Elements/ProgressBar/ProgressBar";

  import Colors from "./../../components/Elements/ProgressBar/Colors";
  import ColorsCode from "!raw-loader!./../../components/Elements/ProgressBar/Colors";

  import Sizes from "./../../components/Elements/ProgressBar/Sizes";
  import SizesCode from "!raw-loader!./../../components/Elements/ProgressBar/Sizes";

  import Indeterminate from "./../../components/Elements/ProgressBar/Indeterminate";
  import IndeterminateCode from "!raw-loader!./../../components/Elements/ProgressBar/Indeterminate";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Progress Bar',
      }
    },
    computed: {
      ProgressBarCode() {
        return ProgressBarCode
      },
      SizesCode() {
        return SizesCode
      },
      ColorsCode() {
        return ColorsCode
      },
      IndeterminateCode() {
        return IndeterminateCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      ProgressBar,
      Colors,
      Sizes,
      Indeterminate,
    },
    methods:{
    },

  }
</script>
