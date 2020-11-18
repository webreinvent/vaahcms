<template>
  <div>

    <TopMenu></TopMenu>
    <BlockTopMenu></BlockTopMenu>
    <PageHeader></PageHeader>


    <div class="main-content">


        <Cheatsheet></Cheatsheet>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import Cheatsheet from "../components/Cheatsheet";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Cheat Sheet',
      }
    },
    computed: {
    },
    components: {
       ...globalComponents,
      BlockTopMenu,
      Cheatsheet,
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
