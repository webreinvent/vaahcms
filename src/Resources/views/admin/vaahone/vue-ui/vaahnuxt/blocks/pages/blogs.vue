<template>

  <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Blogs UI Block" :code="BlogsCode">
        <Blogs :content="c.Blogs"></Blogs>
      </SectionCode>


    </div>

    <Footer></Footer>


  </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import Blogs from "../../../vaahnuxt/blocks/components/Blogs";
  import BlogsCode from "!raw-loader!../../../vaahnuxt/blocks/components/Blogs";



  export default {
    layout: 'ui/blocks',
    head () {
      return {
        title: 'VaahNuxt UI components- Blogs',
      }
    },
    computed: {
      BlogsCode() {
        return BlogsCode
      },
    },
    components: {
       ...globalComponents,
      BlockTopMenu,
      Blogs,
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
