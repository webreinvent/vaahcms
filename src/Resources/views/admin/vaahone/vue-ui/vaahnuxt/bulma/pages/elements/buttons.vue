<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Button" :code="ButtonCode">
        <Button></Button>
      </SectionCode>


      <SectionCode name="Colors" :code="ColorsCode">
        <Colors></Colors>
      </SectionCode>


      <SectionCode name="Sizes" :code="SizesCode">
        <Sizes></Sizes>
      </SectionCode>


      <SectionCode name="Displays" :code="DisplaysCode">
        <Displays></Displays>
      </SectionCode>


      <SectionCode name="Styles" :code="StylesCode">
        <Styles></Styles>
      </SectionCode>


      <SectionCode name="States" :code="StatesCode">
        <States></States>
      </SectionCode>


      <SectionCode name="Button Group" :code="ButtonGroupCode">
        <ButtonGroup></ButtonGroup>
      </SectionCode>


      <SectionCode name="Button Addons" :code="ButtonAddonsCode">
        <ButtonAddons></ButtonAddons>
      </SectionCode>


      <SectionCode name="Button Group With Addons" :code="ButtonGroupWithAddonsCode">
        <ButtonGroupWithAddons></ButtonGroupWithAddons>
      </SectionCode>


      <SectionCode name="List Of Buttons" :code="ListOfButtonsCode">
        <ListOfButtons></ListOfButtons>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Button from "./../../components/Elements/Buttons/Button";
  import ButtonCode from "!raw-loader!./../../components/Elements/Buttons/Button";

  import Colors from "./../../components/Elements/Buttons/Colors";
  import ColorsCode from "!raw-loader!./../../components/Elements/Buttons/Colors";

  import Sizes from "./../../components/Elements/Buttons/Sizes";
  import SizesCode from "!raw-loader!./../../components/Elements/Buttons/Sizes";

  import Displays from "./../../components/Elements/Buttons/Displays";
  import DisplaysCode from "!raw-loader!./../../components/Elements/Buttons/Displays";

  import Styles from "./../../components/Elements/Buttons/Styles";
  import StylesCode from "!raw-loader!./../../components/Elements/Buttons/Styles";

  import States from "./../../components/Elements/Buttons/States";
  import StatesCode from "!raw-loader!./../../components/Elements/Buttons/States";

  import ButtonGroup from "./../../components/Elements/Buttons/ButtonGroup";
  import ButtonGroupCode from "!raw-loader!./../../components/Elements/Buttons/ButtonGroup";

  import ButtonAddons from "./../../components/Elements/Buttons/ButtonAddons";
  import ButtonAddonsCode from "!raw-loader!./../../components/Elements/Buttons/ButtonAddons";

  import ButtonGroupWithAddons from "./../../components/Elements/Buttons/ButtonGroupWithAddons";
  import ButtonGroupWithAddonsCode from "!raw-loader!./../../components/Elements/Buttons/ButtonGroupWithAddons";

  import ListOfButtons from "./../../components/Elements/Buttons/ListOfButtons";
  import ListOfButtonsCode from "!raw-loader!./../../components/Elements/Buttons/ListOfButtons";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Button',
      }
    },
    computed: {
      ButtonCode() {
        return ButtonCode
      },
      ColorsCode() {
        return ColorsCode
      },
      SizesCode() {
        return SizesCode
      },
      DisplaysCode() {
        return DisplaysCode
      },
      StylesCode() {
        return StylesCode
      },
      StatesCode() {
        return StatesCode
      },
      ButtonGroupCode() {
        return ButtonGroupCode
      },
      ButtonAddonsCode() {
        return ButtonAddonsCode
      },
      ButtonGroupWithAddonsCode() {
        return ButtonGroupWithAddonsCode
      },
      ListOfButtonsCode() {
        return ListOfButtonsCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Button,
      Colors,
      Sizes,
      Displays,
      Styles,
      States,
      ButtonGroup,
      ButtonAddons,
      ButtonGroupWithAddons,
      ListOfButtons,
    },
    methods:{
    },

  }
</script>
