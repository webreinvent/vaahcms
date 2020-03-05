<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Complete Form Example" :code="CompleteFormExampleCode">
        <CompleteFormExample></CompleteFormExample>
      </SectionCode>


      <SectionCode name="Form Field" :code="FormFieldCode">
        <FormField></FormField>
      </SectionCode>


      <SectionCode name="Form Control" :code="FormControlCode">
        <FormControl></FormControl>
      </SectionCode>


      <SectionCode name="With Icons" :code="WithIconsCode">
        <WithIcons></WithIcons>
      </SectionCode>


      <SectionCode name="Form Addons" :code="FormAddonsCode">
        <FormAddons></FormAddons>
      </SectionCode>


      <SectionCode name="Form Group" :code="FormGroupCode">
        <FormGroup></FormGroup>
      </SectionCode>


      <SectionCode name="Horizontal Form" :code="HorizontalFormCode">
        <HorizontalForm></HorizontalForm>
      </SectionCode>


      <SectionCode name="Disabled Form" :code="DisabledFormCode">
        <DisabledForm></DisabledForm>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import CompleteFormExample from "./../../components/Forms/General/CompleteFormExample";
  import CompleteFormExampleCode from "!raw-loader!./../../components/Forms/General/CompleteFormExample";

  import FormField from "./../../components/Forms/General/FormField";
  import FormFieldCode from "!raw-loader!./../../components/Forms/General/FormField";

  import FormControl from "./../../components/Forms/General/FormControl";
  import FormControlCode from "!raw-loader!./../../components/Forms/General/FormControl";

  import WithIcons from "./../../components/Forms/General/WithIcons";
  import WithIconsCode from "!raw-loader!./../../components/Forms/General/WithIcons";

  import FormAddons from "./../../components/Forms/General/FormAddons";
  import FormAddonsCode from "!raw-loader!./../../components/Forms/General/FormAddons";

  import FormGroup from "./../../components/Forms/General/FormGroup";
  import FormGroupCode from "!raw-loader!./../../components/Forms/General/FormGroup";

  import HorizontalForm from "./../../components/Forms/General/HorizontalForm";
  import HorizontalFormCode from "!raw-loader!./../../components/Forms/General/HorizontalForm";

  import DisabledForm from "./../../components/Forms/General/DisabledForm";
  import DisabledFormCode from "!raw-loader!./../../components/Forms/General/DisabledForm";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- General',
      }
    },
    computed: {
      CompleteFormExampleCode() {
        return CompleteFormExampleCode
      },
      FormFieldCode() {
        return FormFieldCode
      },
      FormControlCode() {
        return FormControlCode
      },
      WithIconsCode() {
        return WithIconsCode
      },
      FormAddonsCode() {
        return FormAddonsCode
      },
      FormGroupCode() {
        return FormGroupCode
      },
      HorizontalFormCode() {
        return HorizontalFormCode
      },
      DisabledFormCode() {
        return DisabledFormCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      CompleteFormExample,
      FormField,
      FormControl,
      WithIcons,
      FormAddons,
      FormGroup,
      HorizontalForm,
      DisabledForm,
    },
    methods:{
    },

  }
</script>
