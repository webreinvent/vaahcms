<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Select" :code="SelectCode">
        <Select></Select>
      </SectionCode>


      <SectionCode name="MultipleSelect" :code="MultipleSelectCode">
        <MultipleSelect></MultipleSelect>
      </SectionCode>


      <SectionCode name="Colors" :code="ColorsCode">
        <Colors></Colors>
      </SectionCode>


      <SectionCode name="Styles" :code="StylesCode">
        <Styles></Styles>
      </SectionCode>


      <SectionCode name="Sizes" :code="SizesCode">
        <Sizes></Sizes>
      </SectionCode>


      <SectionCode name="States" :code="StatesCode">
        <States></States>
      </SectionCode>


      <SectionCode name="WithIcons" :code="WithIconsCode">
        <WithIcons></WithIcons>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Select from "./../../components/Forms/Select/Select";
  import SelectCode from "!raw-loader!./../../components/Forms/Select/Select";

  import MultipleSelect from "./../../components/Forms/Select/MultipleSelect";
  import MultipleSelectCode from "!raw-loader!./../../components/Forms/Select/MultipleSelect";

  import Colors from "./../../components/Forms/Select/Colors";
  import ColorsCode from "!raw-loader!./../../components/Forms/Select/Colors";

  import Styles from "./../../components/Forms/Select/Styles";
  import StylesCode from "!raw-loader!./../../components/Forms/Select/Styles";

  import Sizes from "./../../components/Forms/Select/Sizes";
  import SizesCode from "!raw-loader!./../../components/Forms/Select/Sizes";

  import States from "./../../components/Forms/Select/States";
  import StatesCode from "!raw-loader!./../../components/Forms/Select/States";

  import WithIcons from "./../../components/Forms/Select/WithIcons";
  import WithIconsCode from "!raw-loader!./../../components/Forms/Select/WithIcons";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Select',
      }
    },
    computed: {
      SelectCode() {
        return SelectCode
      },
      MultipleSelectCode() {
        return MultipleSelectCode
      },
      ColorsCode() {
        return ColorsCode
      },
      StylesCode() {
        return StylesCode
      },
      SizesCode() {
        return SizesCode
      },
      StatesCode() {
        return StatesCode
      },
      WithIconsCode() {
        return WithIconsCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Select,
      MultipleSelect,
      Colors,
      Styles,
      Sizes,
      States,
      WithIcons,
    },
    methods:{
    },

  }
</script>
