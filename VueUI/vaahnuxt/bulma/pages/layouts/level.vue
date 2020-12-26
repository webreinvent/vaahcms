<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Level" :code="LevelSnippetCode">
        <LevelSnippet></LevelSnippet>
      </SectionCode>


      <SectionCode name="Centered Level" :code="CenteredLevelCode">
        <CenteredLevel></CenteredLevel>
      </SectionCode>


      <SectionCode name="Mobile Level" :code="MobileLevelCode">
        <MobileLevel></MobileLevel>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import LevelSnippet from "./../../components/Layouts/Level/LevelSnippet";
  import LevelSnippetCode from "!raw-loader!./../../components/Layouts/Level/LevelSnippet";

  import CenteredLevel from "./../../components/Layouts/Level/CenteredLevel";
  import CenteredLevelCode from "!raw-loader!./../../components/Layouts/Level/CenteredLevel";

  import MobileLevel from "./../../components/Layouts/Level/MobileLevel";
  import MobileLevelCode from "!raw-loader!./../../components/Layouts/Level/MobileLevel";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Level',
      }
    },
    computed: {
      LevelSnippetCode() {
        return LevelSnippetCode
      },
      CenteredLevelCode() {
        return CenteredLevelCode
      },
      MobileLevelCode() {
        return MobileLevelCode
      }
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      LevelSnippet,
      CenteredLevel,
      MobileLevel,
    },
    methods:{
    },

  }
</script>
