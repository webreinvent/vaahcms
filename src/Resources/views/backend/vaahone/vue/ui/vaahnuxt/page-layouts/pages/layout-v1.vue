<template>

   <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

  <div class="main-content">


    <SectionCode name="Page-Layout-v1 Header" :code="LayoutV1HeaderCode">
      <LayoutV1Header></LayoutV1Header>
    </SectionCode>


    <SectionCode name="Page-Layout-v1 Tabs" :code="LayoutV1TabsCode">
      <LayoutV1Tabs></LayoutV1Tabs>
    </SectionCode>


    <SectionCode name="Page-Layout-v1 Media Objects" :code="LayoutV1MediaObjectCode">
      <LayoutV1MediaObject></LayoutV1MediaObject>
    </SectionCode>


  </div>

    <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../content/content.json'

  import BlockTopMenu from "../partials/PageLayoutTopMenu";

  import LayoutV1Header from "../components/LayoutV1/LayoutV1Header";
  import LayoutV1HeaderCode from "!raw-loader!../components/LayoutV1/LayoutV1Header";

  import LayoutV1Tabs from "../components/LayoutV1/LayoutV1Tabs";
  import LayoutV1TabsCode from "!raw-loader!../components/LayoutV1/LayoutV1Tabs";

  import LayoutV1MediaObject from "../components/LayoutV1/LayoutV1MediaObject";
  import LayoutV1MediaObjectCode from "!raw-loader!../components/LayoutV1/LayoutV1MediaObject";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Page LayoutV1',
      }
    },
    computed: {
      LayoutV1HeaderCode() {
        return LayoutV1HeaderCode
      },
      LayoutV1TabsCode() {
        return LayoutV1TabsCode
      },
      LayoutV1MediaObjectCode() {
        return LayoutV1MediaObjectCode
      }
    },
    components: {
       ...globalComponents,
      BlockTopMenu,
      LayoutV1Header,
      LayoutV1Tabs,
      LayoutV1MediaObject,
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
