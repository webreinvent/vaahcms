<template>

   <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

  <div class="main-content">


    <SectionCode name="Post Details Page" :code="PostDetailsV1Code">
      <PostDetailsV1></PostDetailsV1>
    </SectionCode>


  </div>

    <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../content/content.json'

  import BlockTopMenu from "../partials/PageLayoutTopMenu";

  import PostDetailsV1 from "../components/PostDetails/PostDetailsV1";
  import PostDetailsV1Code from "!raw-loader!../components/PostDetails/PostDetailsV1";




  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Point of Sale',
      }
    },
    computed: {
      PostDetailsV1Code() {
        return PostDetailsV1Code
      },
    },
    components: {
       ...globalComponents,
      BlockTopMenu,
      PostDetailsV1,
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
