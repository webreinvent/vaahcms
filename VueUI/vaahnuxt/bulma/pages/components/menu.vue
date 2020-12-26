<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Menu" :code="MenuCode">
        <Menu></Menu>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Menu from "./../../components/Components/Menu/Menu";
  import MenuCode from "!raw-loader!./../../components/Components/Menu/Menu";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Menu',
      }
    },
    computed: {
      MenuCode() {
        return MenuCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Menu,
    },
    methods:{
    },

  }
</script>
