<template>

   <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

      <div class="main-content">


      <SectionCode name="Form-Page-v3" :code="FormPageV3Code">
        <FormPageV3></FormPageV3>
      </SectionCode>


      </div>

    <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../content/content.json'

  import BlockTopMenu from "../partials/PageLayoutTopMenu";

  import FormPageV3 from "../components/FormPageV3/FormPageV3";
  import FormPageV3Code from "!raw-loader!../components/FormPageV3/FormPageV3";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Page Layout-v3',
      }
    },
    computed: {
      FormPageV3Code() {
        return FormPageV3Code
      },
    },
    components: {
       ...globalComponents,
      BlockTopMenu,
      FormPageV3,
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
