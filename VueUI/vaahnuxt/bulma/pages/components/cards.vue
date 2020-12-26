<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Card" :code="CardCode">
        <Card></Card>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Card from "./../../components/Components/Cards/Card";
  import CardCode from "!raw-loader!./../../components/Components/Cards/Card";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Card',
      }
    },
    computed: {
      CardCode() {
        return CardCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Card,
    },
    methods:{
    },

  }
</script>
