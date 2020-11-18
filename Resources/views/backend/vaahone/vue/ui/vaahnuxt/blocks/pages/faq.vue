<template>
  <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>


      <div class="main-content">



        <SectionCode name="FrequentlyAskedQuestions UI Block" :code="FrequentlyAskedQuestionsCode">
          <FrequentlyAskedQuestions :content="c.FrequentlyAskedQuestions"></FrequentlyAskedQuestions>
        </SectionCode>


      </div>


    <Footer></Footer>

  </div>
</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import FrequentlyAskedQuestions from "../../../vaahnuxt/blocks/components/FrequentlyAskedQuestions";
  import FrequentlyAskedQuestionsCode from "!raw-loader!../../../vaahnuxt/blocks/components/FrequentlyAskedQuestions";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- FAQ',
      }
    },
    computed: {
      FrequentlyAskedQuestionsCode() {
        return FrequentlyAskedQuestionsCode
      },
    },
    components: {
      ...globalComponents,
      BlockTopMenu,
      FrequentlyAskedQuestions,
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
