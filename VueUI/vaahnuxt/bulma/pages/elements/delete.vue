<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Delete" :code="DeleteCode">
        <Delete></Delete>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Delete from "./../../components/Elements/Delete/Delete";
  import DeleteCode from "!raw-loader!./../../components/Elements/Delete/Delete";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Delete',
      }
    },
    computed: {
      DeleteCode() {
        return DeleteCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Delete,
    },
    methods:{
    },

  }
</script>
