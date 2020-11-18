<template>

   <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

  <div class="main-content">


    <SectionCode name="Post Page" :code="PostPageCode">
      <PostPage></PostPage>
    </SectionCode>


  </div>

    <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../content/content.json'

  import BlockTopMenu from "../partials/PageLayoutTopMenu";

  import PostPage from "../components/PostPage/PostPage";
  import PostPageCode from "!raw-loader!../components/PostPage/PostPage";




  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Point of Sale',
      }
    },
    computed: {
      PostPageCode() {
        return PostPageCode
      },
    },
    components: {
       ...globalComponents,
      BlockTopMenu,
      PostPage,
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
