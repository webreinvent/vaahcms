<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Tags" :code="TagsCode">
        <Tags></Tags>
      </SectionCode>


      <SectionCode name="Colors" :code="ColorsCode">
        <Colors></Colors>
      </SectionCode>


      <SectionCode name="Sizes" :code="SizesCode">
        <Sizes></Sizes>
      </SectionCode>


      <SectionCode name="Modifiers" :code="ModifiersCode">
        <Modifiers></Modifiers>
      </SectionCode>


      <SectionCode name="Combinations" :code="CombinationsCode">
        <Combinations></Combinations>
      </SectionCode>


      <SectionCode name="List Of Tags" :code="ListOfTagsCode">
        <ListOfTags></ListOfTags>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Tags from "./../../components/Elements/Tags/Tags";
  import TagsCode from "!raw-loader!./../../components/Elements/Tags/Tags";

  import Colors from "./../../components/Elements/Tags/Colors";
  import ColorsCode from "!raw-loader!./../../components/Elements/Tags/Colors";

  import Sizes from "./../../components/Elements/Tags/Sizes";
  import SizesCode from "!raw-loader!./../../components/Elements/Tags/Sizes";

  import Modifiers from "./../../components/Elements/Tags/Modifiers";
  import ModifiersCode from "!raw-loader!./../../components/Elements/Tags/Modifiers";

  import Combinations from "./../../components/Elements/Tags/Combinations";
  import CombinationsCode from "!raw-loader!./../../components/Elements/Tags/Combinations";

  import ListOfTags from "./../../components/Elements/Tags/ListOfTags";
  import ListOfTagsCode from "!raw-loader!./../../components/Elements/Tags/ListOfTags";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Tags',
      }
    },
    computed: {
      TagsCode() {
        return TagsCode
      },
      ColorsCode() {
        return ColorsCode
      },
      SizesCode() {
        return SizesCode
      },
      ModifiersCode() {
        return ModifiersCode
      },
      CombinationsCode() {
        return CombinationsCode
      },
      ListOfTagsCode() {
        return ListOfTagsCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Tags,
      Colors,
      Sizes,
      Modifiers,
      Combinations,
      ListOfTags,
    },
    methods:{
    },

  }
</script>
