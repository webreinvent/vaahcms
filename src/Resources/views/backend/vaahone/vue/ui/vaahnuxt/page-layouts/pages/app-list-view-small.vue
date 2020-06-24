<template>

   <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

  <div class="main-content">


    <SectionCode name="App List View Small" :code="AppListViewSmallCode">
      <AppListViewSmall></AppListViewSmall>
    </SectionCode>


  </div>

    <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../content/content.json'

  import BlockTopMenu from "../partials/PageLayoutTopMenu";

  import AppListViewSmall from "../components/AppListViewSmall/AppListViewSmall";
  import AppListViewSmallCode from "!raw-loader!../components/AppListViewSmall/AppListViewSmall";




  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- App List View Small',
      }
    },
    computed: {
      AppListViewSmallCode() {
        return AppListViewSmallCode
      },
    },
    components: {
       ...globalComponents,
      BlockTopMenu,
      AppListViewSmall,
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
