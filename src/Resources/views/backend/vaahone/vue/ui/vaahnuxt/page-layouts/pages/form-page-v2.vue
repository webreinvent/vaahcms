<template>

   <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

      <div class="main-content">


      <SectionCode name="Form-Page-v2" :code="FormPageV2Code">
        <FormPageV2></FormPageV2>
      </SectionCode>


      </div>

    <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../content/content.json'

  import BlockTopMenu from "../partials/PageLayoutTopMenu";

  import FormPageV2 from "../components/FormPageV2/FormPageV2";
  import FormPageV2Code from "!raw-loader!../components/FormPageV2/FormPageV2";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Page Layout-v2',
      }
    },
    computed: {
      FormPageV2Code() {
        return FormPageV2Code
      },
    },
    components: {
       ...globalComponents,
      BlockTopMenu,
      FormPageV2,
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
