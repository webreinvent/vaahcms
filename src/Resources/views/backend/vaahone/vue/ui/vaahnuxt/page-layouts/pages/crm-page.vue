<template>

   <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

      <div class="main-content">


      <SectionCode name="CRM Page" :code="CRMPageCode">
        <CRMPage></CRMPage>
      </SectionCode>


      <SectionCode name="CRM Page Single Box" :code="CRMPageSingleBoxCode">
        <CRMPageSingleBox></CRMPageSingleBox>
      </SectionCode>


      <SectionCode name="CRM Page Single Box Content" :code="CRMPageSingleBoxContentCode">
        <CRMPageSingleBoxContent></CRMPageSingleBoxContent>
      </SectionCode>


      </div>

    <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../content/content.json'

  import BlockTopMenu from "../partials/PageLayoutTopMenu";

  import CRMPage from "../components/CRMPage/CRMPage";
  import CRMPageCode from "!raw-loader!../components/CRMPage/CRMPage";

  import CRMPageSingleBox from "../components/CRMPage/CRMPageSingleBox";
  import CRMPageSingleBoxCode from "!raw-loader!../components/CRMPage/CRMPageSingleBox";

  import CRMPageSingleBoxContent from "../components/CRMPage/CRMPageSingleBoxContent";
  import CRMPageSingleBoxContentCode from "!raw-loader!../components/CRMPage/CRMPageSingleBoxContent";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- CRM Page',
      }
    },
    computed: {
      CRMPageCode() {
        return CRMPageCode
      },
      CRMPageSingleBoxCode() {
        return CRMPageSingleBoxCode
      },
      CRMPageSingleBoxContentCode() {
        return CRMPageSingleBoxContentCode
      },
    },
    components: {
       ...globalComponents,
      BlockTopMenu,
      CRMPage,
      CRMPageSingleBox,
      CRMPageSingleBoxContent,
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
