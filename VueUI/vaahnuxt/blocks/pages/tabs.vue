<template>


 <div>

    <TopMenu></TopMenu>
    <BlockTopMenu></BlockTopMenu>
    <PageHeader></PageHeader>


    <div class="main-content">


    <SectionCode name="ServicesLoopTabsAndPills UI Block" :code="ServicesLoopTabsAndPillsCode">
      <ServicesLoopTabsAndPills :content="c.ServicesLoopTabsAndPills"></ServicesLoopTabsAndPills>
    </SectionCode>



    <SectionCode name="ServicesLoopTabsAndPillsHorizontal UI Block" :code="ServicesLoopTabsAndPillsHorizontalCode">
      <ServicesLoopTabsAndPillsHorizontal :content="c.ServicesLoopTabsAndPillsHorizontal"></ServicesLoopTabsAndPillsHorizontal>
    </SectionCode>



    <SectionCode name="ServicesLoopTabsAndPillsHorizontalWithAccodian UI Block" :code="ServicesLoopTabsAndPillsHorizontalWithAccodianCode">
      <ServicesLoopTabsAndPillsHorizontalWithAccodian :content="c.ServicesLoopTabsAndPillsHorizontalWithAccodian"></ServicesLoopTabsAndPillsHorizontalWithAccodian>
    </SectionCode>


  </div>



    <Footer></Footer>


  </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import ServicesLoopTabsAndPills from "../../../vaahnuxt/blocks/components/ServicesLoopTabsAndPills";
  import ServicesLoopTabsAndPillsCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopTabsAndPills";

  import ServicesLoopTabsAndPillsHorizontalWithAccodian from "../../../vaahnuxt/blocks/components/ServicesLoopTabsAndPillsHorizontalWithAccodian";
  import ServicesLoopTabsAndPillsHorizontalWithAccodianCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopTabsAndPillsHorizontalWithAccodian";

  import ServicesLoopTabsAndPillsHorizontal from "../../../vaahnuxt/blocks/components/ServicesLoopTabsAndPillsHorizontal";
  import ServicesLoopTabsAndPillsHorizontalCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopTabsAndPillsHorizontal";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Tabs',
      }
    },
    computed: {
      ServicesLoopTabsAndPillsCode() {
        return ServicesLoopTabsAndPillsCode
      },
      ServicesLoopTabsAndPillsHorizontalCode() {
        return ServicesLoopTabsAndPillsHorizontalCode
      },
      ServicesLoopTabsAndPillsHorizontalWithAccodianCode() {
        return ServicesLoopTabsAndPillsHorizontalWithAccodianCode
      }
    },
    components: {
      ...globalComponents,
      BlockTopMenu,
      ServicesLoopTabsAndPills,
      ServicesLoopTabsAndPillsHorizontal,
      ServicesLoopTabsAndPillsHorizontalWithAccodian,
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
