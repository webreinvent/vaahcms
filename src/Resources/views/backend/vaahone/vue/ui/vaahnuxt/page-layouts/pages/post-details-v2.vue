<template>

   <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

  <div class="main-content">


    <SectionCode name="Post Details Page" :code="PostDetailsV2Code">
      <PostDetailsV2></PostDetailsV2>
    </SectionCode>


  </div>

    <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../content/content.json'

  import BlockTopMenu from "../partials/PageLayoutTopMenu";

  import PostDetailsV2 from "../components/PostDetails/PostDetailsV2";
  import PostDetailsV2Code from "!raw-loader!../components/PostDetails/PostDetailsV2";




  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Point of Sale',
      }
    },
    computed: {
      PostDetailsV2Code() {
        return PostDetailsV2Code
      },
    },
    components: {
       ...globalComponents,
      BlockTopMenu,
      PostDetailsV2,
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
