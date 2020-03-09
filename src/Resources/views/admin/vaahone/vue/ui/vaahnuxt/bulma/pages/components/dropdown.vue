<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Dropdown" :code="DropdownCode">
        <Dropdown></Dropdown>
      </SectionCode>


      <SectionCode name="Dropdown Content" :code="DropdownContentCode">
        <DropdownContent></DropdownContent>
      </SectionCode>


      <SectionCode name="Hoverable Or Toggable" :code="HoverableOrToggableCode">
        <HoverableOrToggable></HoverableOrToggable>
      </SectionCode>


      <SectionCode name="Right Aligned" :code="RightAlignedCode">
        <RightAligned></RightAligned>
      </SectionCode>


      <SectionCode name="Dropup" :code="DropupCode">
        <Dropup></Dropup>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Dropdown from "./../../components/Components/Dropdown/Dropdown";
  import DropdownCode from "!raw-loader!./../../components/Components/Dropdown/Dropdown";

  import DropdownContent from "./../../components/Components/Dropdown/DropdownContent";
  import DropdownContentCode from "!raw-loader!./../../components/Components/Dropdown/DropdownContent";

  import HoverableOrToggable from "./../../components/Components/Dropdown/HoverableOrToggable";
  import HoverableOrToggableCode from "!raw-loader!./../../components/Components/Dropdown/HoverableOrToggable";

  import RightAligned from "./../../components/Components/Dropdown/RightAligned";
  import RightAlignedCode from "!raw-loader!./../../components/Components/Dropdown/RightAligned";

  import Dropup from "./../../components/Components/Dropdown/Dropup";
  import DropupCode from "!raw-loader!./../../components/Components/Dropdown/Dropup";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- DropDown',
      }
    },
    computed: {
      DropdownCode() {
        return DropdownCode
      },
      DropdownContentCode() {
        return DropdownContentCode
      },
      HoverableOrToggableCode() {
        return HoverableOrToggableCode
      },
      RightAlignedCode() {
        return RightAlignedCode
      },
      DropupCode() {
        return DropupCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Dropdown,
      DropdownContent,
      HoverableOrToggable,
      RightAligned,
      Dropup,
    },
    methods:{
    },

  }
</script>
