<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Notification" :code="NotificationCode">
        <Notification></Notification>
      </SectionCode>


      <SectionCode name="Colors" :code="ColorsCode">
        <Colors></Colors>
      </SectionCode>


      <SectionCode name="Light Colors" :code="LightColorsCode">
        <LightColors></LightColors>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Notification from "./../../components/Elements/Notification/Notification";
  import NotificationCode from "!raw-loader!./../../components/Elements/Notification/Notification";

  import Colors from "./../../components/Elements/Notification/Colors";
  import ColorsCode from "!raw-loader!./../../components/Elements/Notification/Colors";

  import LightColors from "./../../components/Elements/Notification/LightColors";
  import LightColorsCode from "!raw-loader!./../../components/Elements/Notification/LightColors";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Notification',
      }
    },
    computed: {
      NotificationCode() {
        return NotificationCode
      },
      ColorsCode() {
        return ColorsCode
      },
      LightColorsCode() {
        return LightColorsCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Notification,
      Colors,
      LightColors,
    },
    methods:{
    },

  }
</script>
