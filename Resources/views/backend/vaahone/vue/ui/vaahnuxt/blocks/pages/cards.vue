<template>

  <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>


     <div class="main-content">


        <SectionCode name="ServiceFeatures UI Block" :code="ServiceFeaturesCode">
          <ServiceFeatures :content="c.ServiceFeatures"></ServiceFeatures>
        </SectionCode>



        <SectionCode name="ServicesBigColorBoxes UI Block" :code="ServicesBigColorBoxesCode">
          <ServicesBigColorBoxes :content="c.ServicesBigColorBoxes"></ServicesBigColorBoxes>
        </SectionCode>



        <SectionCode name="ServicesCardWithLeftImage UI Block" :code="ServicesCardWithLeftImageCode">
          <ServicesCardWithLeftImage :content="c.ServicesCardWithLeftImage"></ServicesCardWithLeftImage>
        </SectionCode>



        <SectionCode name="ServicesCardWithLeftRoundImage UI Block" :code="ServicesCardWithLeftRoundImageCode">
          <ServicesCardWithLeftRoundImage :content="c.ServicesCardWithLeftRoundImage"></ServicesCardWithLeftRoundImage>
        </SectionCode>



        <SectionCode name="ServicesLoop UI Block" :code="ServicesLoopCode">
          <ServicesLoop :content="c.ServicesLoop"></ServicesLoop>
        </SectionCode>



        <SectionCode name="ServicesLoopBackgroundImage UI Block" :code="ServicesLoopBackgroundImageCode">
          <ServicesLoopBackgroundImage :content="c.ServicesLoopBackgroundImage"></ServicesLoopBackgroundImage>
        </SectionCode>



        <SectionCode name="ServicesLoopBackgroundImageAndBoxes UI Block" :code="ServicesLoopBackgroundImageAndBoxesCode">
          <ServicesLoopBackgroundImageAndBoxes :content="c.ServicesLoopBackgroundImageAndBoxes"></ServicesLoopBackgroundImageAndBoxes>
        </SectionCode>



        <SectionCode name="ServicesLoopRightImage UI Block" :code="ServicesLoopRightImageCode">
          <ServicesLoopRightImage :content="c.ServicesLoopRightImage"></ServicesLoopRightImage>
        </SectionCode>



        <SectionCode name="ServicesLoopSix UI Block" :code="ServicesLoopSixCode">
          <ServicesLoopSix :content="c.ServicesLoopSix"></ServicesLoopSix>
        </SectionCode>


      </div>

      <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import ServiceFeatures from "../../../vaahnuxt/blocks/components/ServiceFeatures";
  import ServiceFeaturesCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServiceFeatures";

  import ServicesBigColorBoxes from "../../../vaahnuxt/blocks/components/ServicesBigColorBoxes";
  import ServicesBigColorBoxesCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesBigColorBoxes";

  import ServicesCardWithLeftImage from "../../../vaahnuxt/blocks/components/ServicesCardWithLeftImage";
  import ServicesCardWithLeftImageCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesCardWithLeftImage";

  import ServicesCardWithLeftRoundImage from "../../../vaahnuxt/blocks/components/ServicesCardWithLeftRoundImage";
  import ServicesCardWithLeftRoundImageCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesCardWithLeftRoundImage";

  import ServicesLoop from "../../../vaahnuxt/blocks/components/ServicesLoop";
  import ServicesLoopCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoop";

  import ServicesLoopBackgroundImage from "../../../vaahnuxt/blocks/components/ServicesLoopBackgroundImage";
  import ServicesLoopBackgroundImageCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopBackgroundImage";

  import ServicesLoopBackgroundImageAndBoxes from "../../../vaahnuxt/blocks/components/ServicesLoopBackgroundImageAndBoxes";
  import ServicesLoopBackgroundImageAndBoxesCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopBackgroundImageAndBoxes";

  import ServicesLoopRightImage from "../../../vaahnuxt/blocks/components/ServicesLoopRightImage";
  import ServicesLoopRightImageCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopRightImage";

  import ServicesLoopSix from "../../../vaahnuxt/blocks/components/ServicesLoopSix";
  import ServicesLoopSixCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopSix";



  export default {
    layout: 'ui/blocks',
    head () {
      return {
        title: 'VaahNuxt UI components- Cards',
      }
    },
    computed: {
      ServiceFeaturesCode() {
        return ServiceFeaturesCode
      },
      ServicesBigColorBoxesCode() {
        return ServicesBigColorBoxesCode
      },
      ServicesCardWithLeftImageCode() {
        return ServicesCardWithLeftImageCode
      },
      ServicesCardWithLeftRoundImageCode() {
        return ServicesCardWithLeftRoundImageCode
      },
      ServicesLoopCode() {
        return ServicesLoopCode
      },
      ServicesLoopBackgroundImageCode() {
        return ServicesLoopBackgroundImageCode
      },
      ServicesLoopBackgroundImageAndBoxesCode() {
        return ServicesLoopBackgroundImageAndBoxesCode
      },
      ServicesLoopRightImageCode() {
        return ServicesLoopRightImageCode
      },
      ServicesLoopSixCode() {
        return ServicesLoopSixCode
      },
    },
    components: {
      ...globalComponents,
      BlockTopMenu,
      ServiceFeatures,
      ServicesBigColorBoxes,
      ServicesCardWithLeftImage,
      ServicesCardWithLeftRoundImage,
      ServicesLoop,
      ServicesLoopBackgroundImage,
      ServicesLoopBackgroundImageAndBoxes,
      ServicesLoopRightImage,
      ServicesLoopSix,
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
