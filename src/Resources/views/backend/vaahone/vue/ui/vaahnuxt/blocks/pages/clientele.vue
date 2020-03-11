<template>
  <div>

    <TopMenu></TopMenu>
    <BlockTopMenu></BlockTopMenu>
    <PageHeader></PageHeader>


    <div class="main-content">



      <SectionCode name="Clientele UI Block" :code="ClienteleCode">
        <Clientele :content="c.Clientele"></Clientele>
      </SectionCode>



      <SectionCode name="Clients UI Block" :code="ClientsCode">
        <Clients :content="c.Clients"></Clients>
      </SectionCode>


    </div>



    <Footer></Footer>


  </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import Clientele from "../../../vaahnuxt/blocks/components/Clientele";
  import ClienteleCode from "!raw-loader!../../../vaahnuxt/blocks/components/Clientele";

  import Clients from "../../../vaahnuxt/blocks/components/Clients";
  import ClientsCode from "!raw-loader!../../../vaahnuxt/blocks/components/Clients";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Clientele',
      }
    },
    computed: {
      ClienteleCode() {
        return ClienteleCode
      },
      ClientsCode() {
        return ClientsCode
      },
    },
    components: {
      ...globalComponents,
      BlockTopMenu,
      Clientele,
      Clients,
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
