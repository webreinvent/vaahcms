<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Icon" :code="IconCode">
        <Icon></Icon>
      </SectionCode>


      <SectionCode name="Colors" :code="ColorsCode">
        <Colors></Colors>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Icon from "./../../components/Elements/Icon/Icon";
  import IconCode from "!raw-loader!./../../components/Elements/Icon/Icon";

  import Colors from "./../../components/Elements/Icon/Colors";
  import ColorsCode from "!raw-loader!./../../components/Elements/Icon/Colors";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Icon',
      }
    },
    computed: {
      IconCode() {
        return IconCode
      },
      ColorsCode() {
        return ColorsCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Icon,
      Colors,
    },
    methods:{
    },

  }
</script>
