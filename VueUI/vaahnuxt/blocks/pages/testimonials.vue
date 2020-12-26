<template>


<div>

    <TopMenu></TopMenu>
    <BlockTopMenu></BlockTopMenu>
    <PageHeader></PageHeader>


    <div class="main-content">


    <SectionCode name="Testimonials UI Block" :code="TestimonialsCode">
      <Testimonials :content="c.Testimonials"></Testimonials>
    </SectionCode>


  </div>



    <Footer></Footer>


  </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import Testimonials from "../../../vaahnuxt/blocks/components/Testimonials";
  import TestimonialsCode from "!raw-loader!../../../vaahnuxt/blocks/components/Testimonials";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Testimonials',
      }
    },
    computed: {
      TestimonialsCode() {
        return TestimonialsCode
      },
    },
    components: {
      ...globalComponents,
      BlockTopMenu,
      Testimonials,
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
