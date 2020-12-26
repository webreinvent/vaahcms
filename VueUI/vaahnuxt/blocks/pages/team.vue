<template>

 <div>

    <TopMenu></TopMenu>
    <BlockTopMenu></BlockTopMenu>
    <PageHeader></PageHeader>


    <div class="main-content">



    <SectionCode name="Team UI Block" :code="TeamCode">
      <Team :content="c.Team"></Team>
    </SectionCode>



    <SectionCode name="TeamSquareCard UI Block" :code="TeamSquareCardCode">
      <TeamSquareCard :content="c.TeamSquareCard"></TeamSquareCard>
    </SectionCode>


  </div>



    <Footer></Footer>


  </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";

  import Team from "../../../vaahnuxt/blocks/components/Team";
  import TeamCode from "!raw-loader!../../../vaahnuxt/blocks/components/Team";

  import TeamSquareCard from "../../../vaahnuxt/blocks/components/TeamSquareCard";
  import TeamSquareCardCode from "!raw-loader!../../../vaahnuxt/blocks/components/TeamSquareCard";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Team',
      }
    },
    computed: {
      TeamCode() {
        return TeamCode
      },
      TeamSquareCardCode() {
        return TeamSquareCardCode
      },
    },
    components: {
      ...globalComponents,
      BlockTopMenu,
      Team,
      TeamSquareCard,
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
