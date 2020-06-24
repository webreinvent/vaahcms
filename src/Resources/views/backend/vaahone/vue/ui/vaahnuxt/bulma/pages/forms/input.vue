<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Input" :code="InputCode">
        <Input></Input>
      </SectionCode>


      <SectionCode name="Colors" :code="ColorsCode">
        <Colors></Colors>
      </SectionCode>


      <SectionCode name="Sizes" :code="SizesCode">
        <Sizes></Sizes>
      </SectionCode>


      <SectionCode name="Styles" :code="StylesCode">
        <Styles></Styles>
      </SectionCode>


      <SectionCode name="States" :code="StatesCode">
        <States></States>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Input from "./../../components/Forms/Inputs/Input";
  import InputCode from "!raw-loader!./../../components/Forms/Inputs/Input";

  import Colors from "./../../components/Forms/Inputs/Colors";
  import ColorsCode from "!raw-loader!./../../components/Forms/Inputs/Colors";

  import Sizes from "./../../components/Forms/Inputs/Sizes";
  import SizesCode from "!raw-loader!./../../components/Forms/Inputs/Sizes";

  import Styles from "./../../components/Forms/Inputs/Styles";
  import StylesCode from "!raw-loader!./../../components/Forms/Inputs/Styles";

  import States from "./../../components/Forms/Inputs/States";
  import StatesCode from "!raw-loader!./../../components/Forms/Inputs/States";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Input',
      }
    },
    computed: {
      InputCode() {
        return InputCode
      },
      ColorsCode() {
        return ColorsCode
      },
      SizesCode() {
        return SizesCode
      },
      StylesCode() {
        return StylesCode
      },
      StatesCode() {
        return StatesCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Input,
      Colors,
      Sizes,
      Styles,
      States,
    },
    methods:{
    },

  }
</script>
