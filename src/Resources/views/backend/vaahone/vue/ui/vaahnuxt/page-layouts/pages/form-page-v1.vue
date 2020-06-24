<template>

   <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

      <div class="main-content">


      <SectionCode name="Form-Page-V1" :code="FormPageV1Code">
        <FormPageV1></FormPageV1>
      </SectionCode>


      </div>

    <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../content/content.json'

  import BlockTopMenu from "../partials/PageLayoutTopMenu";

  import FormPageV1 from "../components/FormPageV1/FormPageV1";
  import FormPageV1Code from "!raw-loader!../components/FormPageV1/FormPageV1";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Page LayoutV1',
      }
    },
    computed: {
      FormPageV1Code() {
        return FormPageV1Code
      },
    },
    components: {
       ...globalComponents,
      BlockTopMenu,
      FormPageV1,
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
