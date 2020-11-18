<template>


 <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>


      <div class="main-content">


    <SectionCode name="ServiceHeader UI Block" :code="ServiceHeaderCode">
      <ServiceHeader :content="c.ServiceHeader"></ServiceHeader>
    </SectionCode>


  </div>


    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import ServiceHeader from "../../../vaahnuxt/blocks/components/ServiceHeader";
  import ServiceHeaderCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServiceHeader";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Forms',
      }
    },
    computed: {
      ServiceHeaderCode() {
        return ServiceHeaderCode
      },
    },
    components: {
      ...globalComponents,
      BlockTopMenu,
      ServiceHeader,
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
