<template>

  <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>


    <div class="main-content">


      <SectionCode name="CallToAction UI Block" :code="CallToActionCode">
        <CallToAction :content="c.CallToAction"></CallToAction>
      </SectionCode>



      <SectionCode name="CallToActionBGImage UI Block" :code="CallToActionBGImageCode">
        <CallToActionBGImage :content="c.CallToActionBGImage"></CallToActionBGImage>
      </SectionCode>



      <SectionCode name="Slogan UI Block" :code="SloganCode">
        <Slogan :content="c.Slogan"></Slogan>
      </SectionCode>


    </div>

    <Footer></Footer>


  </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import CallToAction from "../../../vaahnuxt/blocks/components/CallToAction";
  import CallToActionCode from "!raw-loader!../../../vaahnuxt/blocks/components/CallToAction";

  import CallToActionBGImage from "../../../vaahnuxt/blocks/components/CallToActionBGImage";
  import CallToActionBGImageCode from "!raw-loader!../../../vaahnuxt/blocks/components/CallToActionBGImage";

  import Slogan from "../../../vaahnuxt/blocks/components/Slogan";
  import SloganCode from "!raw-loader!../../../vaahnuxt/blocks/components/Slogan";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Call to Actions',
      }
    },
    computed: {
      CallToActionCode() {
        return CallToActionCode
      },
      CallToActionBGImageCode() {
        return CallToActionBGImageCode
      },
      SloganCode() {
        return SloganCode
      },
    },
    components: {
      ...globalComponents,
      BlockTopMenu,
      CallToAction,
      CallToActionBGImage,
      Slogan,
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
