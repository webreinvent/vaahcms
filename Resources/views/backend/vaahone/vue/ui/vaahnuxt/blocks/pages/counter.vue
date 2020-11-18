<template>


   <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

     <div class="main-content">


    <SectionCode name="Counter UI Block" :code="CounterCode">
      <Counter :content="c.Counter"></Counter>
    </SectionCode>


  </div>

     <Footer></Footer>

   </div>


</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import Counter from "../../../vaahnuxt/blocks/components/Counter";
  import CounterCode from "!raw-loader!../../../vaahnuxt/blocks/components/Counter";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Counter',
      }
    },
    computed: {
      CounterCode() {
        return CounterCode
      },
    },
    components: {
      ...globalComponents,
      BlockTopMenu,
      Counter,
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
