<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Centered" :code="CenteredCode">
        <Centered></Centered>
      </SectionCode>


      <SectionCode name="Fluid Container" :code="FluidContainerCode">
        <FluidContainer></FluidContainer>
      </SectionCode>


      <SectionCode name="Breakpoint Containers" :code="BreakpointContainersCode">
        <BreakpointContainers></BreakpointContainers>
      </SectionCode>


      <SectionCode name="Full Width Container" :code="FullWidthContainerCode">
        <FullWidthContainer></FullWidthContainer>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Centered from "./../../components/Layouts/Container/Centered";
  import CenteredCode from "!raw-loader!./../../components/Layouts/Container/Centered";

  import FluidContainer from "./../../components/Layouts/Container/FluidContainer";
  import FluidContainerCode from "!raw-loader!./../../components/Layouts/Container/FluidContainer";

  import BreakpointContainers from "./../../components/Layouts/Container/BreakpointContainers";
  import BreakpointContainersCode from "!raw-loader!./../../components/Layouts/Container/BreakpointContainers";

  import FullWidthContainer from "./../../components/Layouts/Container/FullWidthContainer";
  import FullWidthContainerCode from "!raw-loader!./../../components/Layouts/Container/FullWidthContainer";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Container',
      }
    },
    computed: {
      CenteredCode() {
        return CenteredCode
      },
      FluidContainerCode() {
        return FluidContainerCode
      },
      BreakpointContainersCode() {
        return BreakpointContainersCode
      },
      FullWidthContainerCode() {
        return FullWidthContainerCode
      }
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Centered,
      FluidContainer,
      BreakpointContainers,
      FullWidthContainer,
    },
    methods:{
    },

  }
</script>
