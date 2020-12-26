<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Hero" :code="HeroCode">
        <Hero></Hero>
      </SectionCode>


      <SectionCode name="Colors" :code="ColorsCode">
        <Colors></Colors>
      </SectionCode>


      <SectionCode name="Gradients" :code="GradientsCode">
        <Gradients></Gradients>
      </SectionCode>


      <SectionCode name="Sizes" :code="SizesCode">
        <Sizes></Sizes>
      </SectionCode>


      <SectionCode name="Full height With Navbar" :code="FullheightWithNavbarCode">
        <FullheightWithNavbar></FullheightWithNavbar>
      </SectionCode>


      <SectionCode name="Fullheight Hero In 3 parts" :code="FullheightHeroIn3partsCode">
        <FullheightHeroIn3parts></FullheightHeroIn3parts>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Hero from "./../../components/Layouts/Hero/Hero";
  import HeroCode from "!raw-loader!./../../components/Layouts/Hero/Hero";

  import Colors from "./../../components/Layouts/Hero/Colors";
  import ColorsCode from "!raw-loader!./../../components/Layouts/Hero/Colors";

  import Gradients from "./../../components/Layouts/Hero/Gradients";
  import GradientsCode from "!raw-loader!./../../components/Layouts/Hero/Gradients";

  import Sizes from "./../../components/Layouts/Hero/Sizes";
  import SizesCode from "!raw-loader!./../../components/Layouts/Hero/Sizes";

  import FullheightWithNavbar from "./../../components/Layouts/Hero/FullheightWithNavbar";
  import FullheightWithNavbarCode from "!raw-loader!./../../components/Layouts/Hero/FullheightWithNavbar";

  import FullheightHeroIn3parts from "./../../components/Layouts/Hero/FullheightHeroIn3parts";
  import FullheightHeroIn3partsCode from "!raw-loader!./../../components/Layouts/Hero/FullheightHeroIn3parts";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Hero',
      }
    },
    computed: {
      HeroCode() {
        return HeroCode
      },
      ColorsCode() {
        return ColorsCode
      },
      GradientsCode() {
        return GradientsCode
      },
      SizesCode() {
        return SizesCode
      },
      FullheightWithNavbarCode() {
        return FullheightWithNavbarCode
      },
      FullheightHeroIn3partsCode() {
        return FullheightHeroIn3partsCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Hero,
      Colors,
      Gradients,
      Sizes,
      FullheightWithNavbar,
      FullheightHeroIn3parts,
    },
    methods:{
    },

  }
</script>
