<template>

<div>

    <TopMenu></TopMenu>
    <BlockTopMenu></BlockTopMenu>
    <PageHeader></PageHeader>


    <div class="main-content">


      <SectionCode name="Process UI Block" :code="ProcessCode">
        <Process :content="c.Process"></Process>
      </SectionCode>


    </div>



    <Footer></Footer>


  </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import Process from "../../../vaahnuxt/blocks/components/Process";
  import ProcessCode from "!raw-loader!../../../vaahnuxt/blocks/components/Process";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Process',
      }
    },
    computed: {
      ProcessCode() {
        return ProcessCode
      },
    },
    components: {
      ...globalComponents,
      BlockTopMenu,
      Process,
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
