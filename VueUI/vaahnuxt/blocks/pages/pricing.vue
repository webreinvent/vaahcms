<template>
  <div>

    <TopMenu></TopMenu>
    <BlockTopMenu></BlockTopMenu>
    <PageHeader></PageHeader>


     <div class="main-content">



    <SectionCode name="ServicesLoopPricingFourColumns UI Block" :code="ServicesLoopPricingFourColumnsCode">
      <ServicesLoopPricingFourColumns :content="c.ServicesLoopPricingFourColumns"></ServicesLoopPricingFourColumns>
    </SectionCode>



    <SectionCode name="ServicesLoopPricingThreeColumns UI Block" :code="ServicesLoopPricingThreeColumnsCode">
      <ServicesLoopPricingThreeColumns :content="c.ServicesLoopPricingThreeColumns"></ServicesLoopPricingThreeColumns>
    </SectionCode>


  </div>



    <Footer></Footer>


  </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import ServicesLoopPricingFourColumns from "../../../vaahnuxt/blocks/components/ServicesLoopPricingFourColumns";
  import ServicesLoopPricingFourColumnsCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopPricingFourColumns";

  import ServicesLoopPricingThreeColumns from "../../../vaahnuxt/blocks/components/ServicesLoopPricingThreeColumns";
  import ServicesLoopPricingThreeColumnsCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopPricingThreeColumns";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Pricing',
      }
    },
    computed: {
      ServicesLoopPricingFourColumnsCode() {
        return ServicesLoopPricingFourColumnsCode
      },
      ServicesLoopPricingThreeColumnsCode() {
        return ServicesLoopPricingThreeColumnsCode
      }
    },
    components: {
      ...globalComponents,
      BlockTopMenu,
      ServicesLoopPricingFourColumns,
      ServicesLoopPricingThreeColumns,
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
