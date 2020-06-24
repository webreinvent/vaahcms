<template>

   <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

      <div class="main-content">


      <SectionCode name="Form-Page-v4" :code="FormPageV4Code">
        <FormPageV4></FormPageV4>
      </SectionCode>


      </div>

    <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../content/content.json'

  import BlockTopMenu from "../partials/PageLayoutTopMenu";

  import FormPageV4 from "../components/FormPageV4/FormPageV4";
  import FormPageV4Code from "!raw-loader!../components/FormPageV4/FormPageV4";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Page Layout-v4',
      }
    },
    computed: {
      FormPageV4Code() {
        return FormPageV4Code
      },
    },
    components: {
       ...globalComponents,
      BlockTopMenu,
      FormPageV4,
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
