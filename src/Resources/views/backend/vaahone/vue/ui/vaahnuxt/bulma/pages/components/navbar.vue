<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Navbar" :code="NavbarCode">
        <Navbar></Navbar>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Navbar from "./../../components/Components/Navbar/Navbar";
  import NavbarCode from "!raw-loader!./../../components/Components/Navbar/Navbar";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Navbar',
      }
    },
    computed: {
      NavbarCode() {
        return NavbarCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Navbar,
    },
    methods:{
    },

  }
</script>
