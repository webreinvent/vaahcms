<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Breadcrumb" :code="BreadcrumbCode">
        <Breadcrumb></Breadcrumb>
      </SectionCode>


      <SectionCode name="Alignment" :code="AlignmentCode">
        <Alignment></Alignment>
      </SectionCode>


      <SectionCode name="Icons" :code="IconsCode">
        <Icons></Icons>
      </SectionCode>


      <SectionCode name="Alternative Separators" :code="AlternativeSeparatorsCode">
        <AlternativeSeparators></AlternativeSeparators>
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

  import Breadcrumb from "./../../components/Components/Breadcrumb/Breadcrumb";
  import BreadcrumbCode from "!raw-loader!./../../components/Components/Breadcrumb/Breadcrumb";

  import Alignment from "./../../components/Components/Breadcrumb/Alignment";
  import AlignmentCode from "!raw-loader!./../../components/Components/Breadcrumb/Alignment";

  import Icons from "./../../components/Components/Breadcrumb/Icons";
  import IconsCode from "!raw-loader!./../../components/Components/Breadcrumb/Icons";

  import AlternativeSeparators from "./../../components/Components/Breadcrumb/AlternativeSeparators";
  import AlternativeSeparatorsCode from "!raw-loader!./../../components/Components/Breadcrumb/AlternativeSeparators";

  import Sizes from "./../../components/Components/Breadcrumb/Sizes";
  import SizesCode from "!raw-loader!./../../components/Components/Breadcrumb/Sizes";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Breadcrumb',
      }
    },
    computed: {
      BreadcrumbCode() {
        return BreadcrumbCode
      },
      AlignmentCode() {
        return AlignmentCode
      },
      IconsCode() {
        return IconsCode
      },
      AlternativeSeparatorsCode() {
        return AlternativeSeparatorsCode
      },
      SizesCode() {
        return SizesCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Breadcrumb,
      Alignment,
      Icons,
      AlternativeSeparators,
      Sizes,
    },
    methods:{
    },

  }
</script>
