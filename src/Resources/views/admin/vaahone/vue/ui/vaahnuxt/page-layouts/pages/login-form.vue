<template>

   <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

  <div class="main-content">


    <SectionCode name="Page-LoginForm" :code="LoginFormCode">
      <LoginForm></LoginForm>
    </SectionCode>


  </div>

    <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../content/content.json'

  import BlockTopMenu from "../partials/PageLayoutTopMenu";

  import LoginForm from "../components/LoginForm/Login-Form";
  import LoginFormCode from "!raw-loader!../components/LoginForm/Login-Form";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Login Form',
      }
    },
    computed: {
      LoginFormCode() {
        return LoginFormCode
      },
    },
    components: {
       ...globalComponents,
      BlockTopMenu,
      LoginForm,
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
