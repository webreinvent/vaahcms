<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Images" :code="ImagesCode">
        <Images></Images>
      </SectionCode>


      <SectionCode name="Fixed Square Images" :code="FixedSquareImagesCode">
        <FixedSquareImages></FixedSquareImages>
      </SectionCode>


      <SectionCode name="Rounded Images" :code="RoundedImagesCode">
        <RoundedImages></RoundedImages>
      </SectionCode>


      <SectionCode name="Retina Images" :code="RetinaImagesCode">
        <RetinaImages></RetinaImages>
      </SectionCode>


      <SectionCode name="Responsive Images With Ratios" :code="ResponsiveImagesWithRatiosCode">
        <ResponsiveImagesWithRatios></ResponsiveImagesWithRatios>
      </SectionCode>


      <SectionCode name="Arbitrary Ratios With Any Element" :code="ArbitraryRatiosWithAnyElementCode">
        <ArbitraryRatiosWithAnyElement></ArbitraryRatiosWithAnyElement>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Images from "./../../components/Elements/Images/Images";
  import ImagesCode from "!raw-loader!./../../components/Elements/Images/Images";

  import FixedSquareImages from "./../../components/Elements/Images/FixedSquareImages";
  import FixedSquareImagesCode from "!raw-loader!./../../components/Elements/Images/FixedSquareImages";

  import RoundedImages from "./../../components/Elements/Images/RoundedImages";
  import RoundedImagesCode from "!raw-loader!./../../components/Elements/Images/RoundedImages";

  import RetinaImages from "./../../components/Elements/Images/RetinaImages";
  import RetinaImagesCode from "!raw-loader!./../../components/Elements/Images/RetinaImages";

  import ResponsiveImagesWithRatios from "./../../components/Elements/Images/ResponsiveImagesWithRatios";
  import ResponsiveImagesWithRatiosCode from "!raw-loader!./../../components/Elements/Images/ResponsiveImagesWithRatios";

  import ArbitraryRatiosWithAnyElement from "./../../components/Elements/Images/ArbitraryRatiosWithAnyElement";
  import ArbitraryRatiosWithAnyElementCode from "!raw-loader!./../../components/Elements/Images/ArbitraryRatiosWithAnyElement";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Images',
      }
    },
    computed: {
      ImagesCode() {
        return ImagesCode
      },
      FixedSquareImagesCode() {
        return FixedSquareImagesCode
      },
      RoundedImagesCode() {
        return RoundedImagesCode
      },
      RetinaImagesCode() {
        return RetinaImagesCode
      },
      ResponsiveImagesWithRatiosCode() {
        return ResponsiveImagesWithRatiosCode
      },
      ArbitraryRatiosWithAnyElementCode() {
        return ArbitraryRatiosWithAnyElementCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Images,
      FixedSquareImages,
      RoundedImages,
      RetinaImages,
      ResponsiveImagesWithRatios,
      ArbitraryRatiosWithAnyElement,
    },
    methods:{
    },

  }
</script>
