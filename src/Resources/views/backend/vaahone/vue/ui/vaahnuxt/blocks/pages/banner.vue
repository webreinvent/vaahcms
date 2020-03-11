<template>

   <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

  <div class="main-content">


    <SectionCode name="Banner UI Block" :code="BannerCode">
      <Banner :content="c.Banner"></Banner>
    </SectionCode>


  </div>

    <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import Banner from "../../../vaahnuxt/blocks/components/Banner";
  import BannerCode from "!raw-loader!../../../vaahnuxt/blocks/components/Banner";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Banner',
      }
    },
    computed: {
      BannerCode() {
        return BannerCode
      }
    },
    components: {
       ...globalComponents,
      BlockTopMenu,
      Banner,
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
