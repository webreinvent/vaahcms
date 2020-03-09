<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Tabs" :code="TabsCode">
        <Tabs></Tabs>
      </SectionCode>


      <SectionCode name="Alignment" :code="AlignmentCode">
        <Alignment></Alignment>
      </SectionCode>


      <SectionCode name="Icons" :code="IconsCode">
        <Icons></Icons>
      </SectionCode>


      <SectionCode name="Sizes" :code="SizesCode">
        <Sizes></Sizes>
      </SectionCode>


      <SectionCode name="Styles" :code="StylesCode">
        <Styles></Styles>
      </SectionCode>


      <SectionCode name="Combining" :code="CombiningCode">
        <Combining></Combining>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Tabs from "./../../components/Components/Tabs/Tabs";
  import TabsCode from "!raw-loader!./../../components/Components/Tabs/Tabs";

  import Alignment from "./../../components/Components/Tabs/Alignment";
  import AlignmentCode from "!raw-loader!./../../components/Components/Tabs/Alignment";

  import Icons from "./../../components/Components/Tabs/Icons";
  import IconsCode from "!raw-loader!./../../components/Components/Tabs/Icons";

  import Sizes from "./../../components/Components/Tabs/Sizes";
  import SizesCode from "!raw-loader!./../../components/Components/Tabs/Sizes";

  import Styles from "./../../components/Components/Tabs/Styles";
  import StylesCode from "!raw-loader!./../../components/Components/Tabs/Styles";

  import Combining from "./../../components/Components/Tabs/Combining";
  import CombiningCode from "!raw-loader!./../../components/Components/Tabs/Combining";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Tabs',
      }
    },
    computed: {
      TabsCode() {
        return TabsCode
      },
      AlignmentCode() {
        return AlignmentCode
      },
      IconsCode() {
        return IconsCode
      },
      SizesCode() {
        return SizesCode
      },
      StylesCode() {
        return StylesCode
      },
      CombiningCode() {
        return CombiningCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Tabs,
      Alignment,
      Icons,
      Sizes,
      Styles,
      Combining,
    },
    methods:{
    },

  }
</script>
