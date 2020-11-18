<template>


<div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

     <div class="main-content">



    <SectionCode name="ServiceFeaturesListViewCenterImage UI Block" :code="ServiceFeaturesListViewCenterImageCode">
      <ServiceFeaturesListViewCenterImage :content="c.ServiceFeaturesListViewCenterImage"></ServiceFeaturesListViewCenterImage>
    </SectionCode>



    <SectionCode name="ServiceFeaturesFourColouredBoxes UI Block" :code="ServiceFeaturesFourColouredBoxesCode">
      <ServiceFeaturesFourColouredBoxes :content="c.ServiceFeaturesFourColouredBoxes"></ServiceFeaturesFourColouredBoxes>
    </SectionCode>



    <SectionCode name="ServicesListViewThreeColumns UI Block" :code="ServicesListViewThreeColumnsCode">
      <ServicesListViewThreeColumns :content="c.ServicesListViewThreeColumns"></ServicesListViewThreeColumns>
    </SectionCode>



    <SectionCode name="ServicesListView UI Block" :code="ServicesListViewCode">
      <ServicesListView :content="c.ServicesListView"></ServicesListView>
    </SectionCode>



    <SectionCode name="ServicesLoopRoundImageTop UI Block" :code="ServicesLoopRoundImageTopCode">
      <ServicesLoopRoundImageTop :content="c.ServicesLoopRoundImageTop"></ServicesLoopRoundImageTop>
    </SectionCode>



    <SectionCode name="ServicesLoopRoundImageTopThreeColumns UI Block" :code="ServicesLoopRoundImageTopThreeColumnsCode">
      <ServicesLoopRoundImageTopThreeColumns :content="c.ServicesLoopRoundImageTopThreeColumns"></ServicesLoopRoundImageTopThreeColumns>
    </SectionCode>



    <SectionCode name="ServicesListViewThreeColumnsHeading UI Block" :code="ServicesListViewThreeColumnsHeadingCode">
      <ServicesListViewThreeColumnsHeading :content="c.ServicesListViewThreeColumnsHeading"></ServicesListViewThreeColumnsHeading>
    </SectionCode>



    <SectionCode name="ServicesLoopTwoWithBackgroundFiveColumns UI Block" :code="ServicesLoopTwoWithBackgroundFiveColumnsCode">
      <ServicesLoopTwoWithBackgroundFiveColumns :content="c.ServicesLoopTwoWithBackgroundFiveColumns"></ServicesLoopTwoWithBackgroundFiveColumns>
    </SectionCode>



    <SectionCode name="ServicesLoopTwoWithoutBackgroundFiveColumns UI Block" :code="ServicesLoopTwoWithoutBackgroundFiveColumnsCode">
      <ServicesLoopTwoWithoutBackgroundFiveColumns :content="c.ServicesLoopTwoWithoutBackgroundFiveColumns"></ServicesLoopTwoWithoutBackgroundFiveColumns>
    </SectionCode>



    <SectionCode name="ServicesSingleLineContent UI Block" :code="ServicesSingleLineContentCode">
      <ServicesSingleLineContent :content="c.ServicesSingleLineContent"></ServicesSingleLineContent>
    </SectionCode>



    <SectionCode name="ServicesLoopListView UI Block" :code="ServicesLoopListViewCode">
      <ServicesLoopListView :content="c.ServicesLoopListView"></ServicesLoopListView>
    </SectionCode>


  </div>

     <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import ServiceFeaturesFourColouredBoxes from "../../../vaahnuxt/blocks/components/ServiceFeaturesFourColouredBoxes";
  import ServiceFeaturesFourColouredBoxesCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServiceFeaturesFourColouredBoxes";

  import ServiceFeaturesListViewCenterImage from "../../../vaahnuxt/blocks/components/ServiceFeaturesListViewCenterImage";
  import ServiceFeaturesListViewCenterImageCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServiceFeaturesListViewCenterImage";

  import ServicesLoopRoundImageTopThreeColumns from "../../../vaahnuxt/blocks/components/ServicesLoopRoundImageTopThreeColumns";
  import ServicesLoopRoundImageTopThreeColumnsCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopRoundImageTopThreeColumns";

  import ServicesListViewThreeColumns from "../../../vaahnuxt/blocks/components/ServicesListViewThreeColumns";
  import ServicesListViewThreeColumnsCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesListViewThreeColumns";

  import ServicesListView from "../../../vaahnuxt/blocks/components/ServicesListView";
  import ServicesListViewCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesListView";

  import ServicesListViewThreeColumnsHeading from "../../../vaahnuxt/blocks/components/ServicesListViewThreeColumnsHeading";
  import ServicesListViewThreeColumnsHeadingCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesListViewThreeColumnsHeading";

  import ServicesLoopRoundImageTop from "../../../vaahnuxt/blocks/components/ServicesLoopRoundImageTop";
  import ServicesLoopRoundImageTopCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopRoundImageTop";

  import ServicesLoopTwoWithBackgroundFiveColumns from "../../../vaahnuxt/blocks/components/ServicesLoopTwoWithBackgroundFiveColumns";
  import ServicesLoopTwoWithBackgroundFiveColumnsCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopTwoWithBackgroundFiveColumns";

  import ServicesLoopTwoWithoutBackgroundFiveColumns from "../../../vaahnuxt/blocks/components/ServicesLoopTwoWithoutBackgroundFiveColumns";
  import ServicesLoopTwoWithoutBackgroundFiveColumnsCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopTwoWithoutBackgroundFiveColumns";

  import ServicesSingleLineContent from "../../../vaahnuxt/blocks/components/ServicesSingleLineContent";
  import ServicesSingleLineContentCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesSingleLineContent";

  import ServicesLoopListView from "../../../vaahnuxt/blocks/components/ServicesLoopListView";
  import ServicesLoopListViewCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopListView";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- List',
      }
    },
    computed: {
      ServiceFeaturesFourColouredBoxesCode() {
        return ServiceFeaturesFourColouredBoxesCode
      },
      ServiceFeaturesListViewCenterImageCode() {
        return ServiceFeaturesListViewCenterImageCode
      },
      ServicesListViewThreeColumnsCode() {
        return ServicesListViewThreeColumnsCode
      },
      ServicesListViewCode() {
        return ServicesListViewCode
      },
      ServicesListViewThreeColumnsHeadingCode() {
        return ServicesListViewThreeColumnsHeadingCode
      },
      ServicesLoopRoundImageTopCode() {
        return ServicesLoopRoundImageTopCode
      },
      ServicesLoopRoundImageTopThreeColumnsCode() {
        return ServicesLoopRoundImageTopThreeColumnsCode
      },
      ServicesLoopTwoWithBackgroundFiveColumnsCode() {
        return ServicesLoopTwoWithBackgroundFiveColumnsCode
      },
      ServicesLoopTwoWithoutBackgroundFiveColumnsCode() {
        return ServicesLoopTwoWithoutBackgroundFiveColumnsCode
      },
      ServicesSingleLineContentCode() {
        return ServicesSingleLineContentCode
      },
      ServicesLoopListViewCode() {
        return ServicesLoopListViewCode
      }
    },
    components: {
      ...globalComponents,
      BlockTopMenu,
      ServiceFeaturesFourColouredBoxes,
      ServiceFeaturesListViewCenterImage,
      ServicesListViewThreeColumns,
      ServicesListView,
      ServicesListViewThreeColumnsHeading,
      ServicesLoopRoundImageTop,
      ServicesLoopRoundImageTopThreeColumns,
      ServicesLoopTwoWithBackgroundFiveColumns,
      ServicesLoopTwoWithoutBackgroundFiveColumns,
      ServicesSingleLineContent,
      ServicesLoopListView,
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
