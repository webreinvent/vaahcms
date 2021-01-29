<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Textarea" :code="TextareaCode">
        <Textarea></Textarea>
      </SectionCode>


      <SectionCode name="Colors" :code="ColorsCode">
        <Colors></Colors>
      </SectionCode>


      <SectionCode name="Sizes" :code="SizesCode">
        <Sizes></Sizes>
      </SectionCode>


      <SectionCode name="States" :code="StatesCode">
        <States></States>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Textarea from "./../../components/Forms/TextArea/Textarea";
  import TextareaCode from "!raw-loader!./../../components/Forms/TextArea/Textarea";

  import Colors from "./../../components/Forms/TextArea/Colors";
  import ColorsCode from "!raw-loader!./../../components/Forms/TextArea/Colors";

  import Sizes from "./../../components/Forms/TextArea/Sizes";
  import SizesCode from "!raw-loader!./../../components/Forms/TextArea/Sizes";

  import States from "./../../components/Forms/TextArea/States";
  import StatesCode from "!raw-loader!./../../components/Forms/TextArea/States";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Textarea',
      }
    },
    computed: {
      TextareaCode() {
        return TextareaCode
      },
      ColorsCode() {
        return ColorsCode
      },
      SizesCode() {
        return SizesCode
      },
      StatesCode() {
        return StatesCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Textarea,
      Colors,
      Sizes,
      States,
    },
    methods:{
    },

  }
</script>
