<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Table" :code="TableCode">
        <Table></Table>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Table from "./../../components/Elements/Table/Table";
  import TableCode from "!raw-loader!./../../components/Elements/Table/Table";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Table',
      }
    },
    computed: {
      TableCode() {
        return TableCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Table,
    },
    methods:{
    },

  }
</script>
