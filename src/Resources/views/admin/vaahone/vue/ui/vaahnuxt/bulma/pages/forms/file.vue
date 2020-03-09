<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="File Upload" :code="FileUploadCode">
        <FileUpload></FileUpload>
      </SectionCode>


      <SectionCode name="Modifiers" :code="ModifiersCode">
        <Modifiers></Modifiers>
      </SectionCode>


      <SectionCode name="Colors" :code="ColorsCode">
        <Colors></Colors>
      </SectionCode>


      <SectionCode name="Sizes" :code="SizesCode">
        <Sizes></Sizes>
      </SectionCode>


      <SectionCode name="Alignment" :code="AlignmentCode">
        <Alignment></Alignment>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import FileUpload from "./../../components/Forms/File/FileUpload";
  import FileUploadCode from "!raw-loader!./../../components/Forms/File/FileUpload";

  import Modifiers from "./../../components/Forms/File/Modifiers";
  import ModifiersCode from "!raw-loader!./../../components/Forms/File/Modifiers";

  import Colors from "./../../components/Forms/File/Colors";
  import ColorsCode from "!raw-loader!./../../components/Forms/File/Colors";

  import Sizes from "./../../components/Forms/File/Sizes";
  import SizesCode from "!raw-loader!./../../components/Forms/File/Sizes";

  import Alignment from "./../../components/Forms/File/Alignment";
  import AlignmentCode from "!raw-loader!./../../components/Forms/File/Alignment";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- File Upload',
      }
    },
    computed: {
      FileUploadCode() {
        return FileUploadCode
      },
      ModifiersCode() {
        return ModifiersCode
      },
      ColorsCode() {
        return ColorsCode
      },
      SizesCode() {
        return SizesCode
      },
      AlignmentCode() {
        return AlignmentCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      FileUpload,
      Modifiers,
      Colors,
      Sizes,
      Alignment,
    },
    methods:{
    },

  }
</script>
