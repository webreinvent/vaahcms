<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Panel" :code="PanelCode">
        <Panel></Panel>
      </SectionCode>


      <SectionCode name="Colors" :code="ColorsCode">
        <Colors></Colors>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Panel from "./../../components/Components/Panel/Panel";
  import PanelCode from "!raw-loader!./../../components/Components/Panel/Panel";

  import Colors from "./../../components/Components/Panel/Colors";
  import ColorsCode from "!raw-loader!./../../components/Components/Panel/Colors";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Panel',
      }
    },
    computed: {
      PanelCode() {
        return PanelCode
      },
      ColorsCode() {
        return ColorsCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Panel,
      Colors,
    },
    methods:{
    },

  }
</script>
