<template>

   <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

  <div class="main-content">


    <SectionCode name="Point Of Sale Page" :code="PointOfSalePageCode">
      <PointOfSalePage></PointOfSalePage>
    </SectionCode>


    <SectionCode name="Sidebar" :code="SidebarCode">
      <Sidebar></Sidebar>
    </SectionCode>


    <SectionCode name="List View" :code="ListViewCode">
      <ListView></ListView>
    </SectionCode>


  </div>

    <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../content/content.json'

  import BlockTopMenu from "../partials/PageLayoutTopMenu";

  import PointOfSalePage from "../components/PointOfSalePage/PointOfSalePage";
  import PointOfSalePageCode from "!raw-loader!../components/PointOfSalePage/PointOfSalePage";

  import Sidebar from "../components/PointOfSalePage/Sidebar";
  import SidebarCode from "!raw-loader!../components/PointOfSalePage/Sidebar";

  import ListView from "../components/PointOfSalePage/ListView";
  import ListViewCode from "!raw-loader!../components/PointOfSalePage/ListView";




  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Point of Sale',
      }
    },
    computed: {
      PointOfSalePageCode() {
        return PointOfSalePageCode
      },
      SidebarCode() {
        return SidebarCode
      },
      ListViewCode() {
        return ListViewCode
      },
    },
    components: {
       ...globalComponents,
      BlockTopMenu,
      PointOfSalePage,
      Sidebar,
      ListView,
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
