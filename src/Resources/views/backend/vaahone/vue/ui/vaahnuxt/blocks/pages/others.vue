<template>


<div>

    <TopMenu></TopMenu>
    <BlockTopMenu></BlockTopMenu>
    <PageHeader></PageHeader>


   <div class="main-content">


    <SectionCode name="ServiceFeaturesNumbersTop UI Block" :code="ServiceFeaturesNumbersTopCode">
      <ServiceFeaturesNumbersTop :content="c.ServiceFeaturesNumbersTop"></ServiceFeaturesNumbersTop>
    </SectionCode>



    <SectionCode name="ServiceFeaturesNumbersTopThreeColumns UI Block" :code="ServiceFeaturesNumbersTopThreeColumnsCode">
      <ServiceFeaturesNumbersTopThreeColumns :content="c.ServiceFeaturesNumbersTopThreeColumns"></ServiceFeaturesNumbersTopThreeColumns>
    </SectionCode>



    <SectionCode name="ServiceLoopFive UI Block" :code="ServiceLoopFiveCode">
      <ServiceLoopFive :content="c.ServiceLoopFive"></ServiceLoopFive>
    </SectionCode>



    <SectionCode name="ServiceLoopFiveThreeColumns UI Block" :code="ServiceLoopFiveThreeColumnsCode">
      <ServiceLoopFiveThreeColumns :content="c.ServiceLoopFiveThreeColumns"></ServiceLoopFiveThreeColumns>
    </SectionCode>


  </div>



    <Footer></Footer>


  </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import ServiceFeaturesNumbersTop from "../../../vaahnuxt/blocks/components/ServiceFeaturesNumbersTop";
  import ServiceFeaturesNumbersTopCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServiceFeaturesNumbersTop";

  import ServiceFeaturesNumbersTopThreeColumns from "../../../vaahnuxt/blocks/components/ServiceFeaturesNumbersTopThreeColumns";
  import ServiceFeaturesNumbersTopThreeColumnsCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServiceFeaturesNumbersTopThreeColumns";

  import ServiceLoopFive from "../../../vaahnuxt/blocks/components/ServiceLoopFive";
  import ServiceLoopFiveCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServiceLoopFive";

  import ServiceLoopFiveThreeColumns from "../../../vaahnuxt/blocks/components/ServiceLoopFiveThreeColumns";
  import ServiceLoopFiveThreeColumnsCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServiceLoopFiveThreeColumns";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Blocks',
      }
    },
    computed: {
      ServiceFeaturesNumbersTopCode() {
        return ServiceFeaturesNumbersTopCode
      },
      ServiceFeaturesNumbersTopThreeColumnsCode() {
        return ServiceFeaturesNumbersTopThreeColumnsCode
      },
      ServiceLoopFiveCode() {
        return ServiceLoopFiveCode
      },
      ServiceLoopFiveThreeColumnsCode() {
        return ServiceLoopFiveThreeColumnsCode
      },
    },
    components: {
      ...globalComponents,
      BlockTopMenu,
      ServiceFeaturesNumbersTop,
      ServiceFeaturesNumbersTopThreeColumns,
      ServiceLoopFive,
      ServiceLoopFiveThreeColumns,
    },
    data(){
      let obj = {
        c: content
      };
      return obj;
    },
    methods:{
    },

  }
</script>
