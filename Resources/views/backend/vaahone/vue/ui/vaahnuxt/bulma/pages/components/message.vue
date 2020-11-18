<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Message" :code="MessageCode">
        <Message></Message>
      </SectionCode>


      <SectionCode name="Colors" :code="ColorsCode">
        <Colors></Colors>
      </SectionCode>


      <SectionCode name="Message Body Only" :code="MessageBodyOnlyCode">
        <MessageBodyOnly></MessageBodyOnly>
      </SectionCode>


      <SectionCode name="Sizes" :code="SizesCode">
        <Sizes></Sizes>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Message from "./../../components/Components/Message/Message";
  import MessageCode from "!raw-loader!./../../components/Components/Message/Message";

  import Colors from "./../../components/Components/Message/Colors";
  import ColorsCode from "!raw-loader!./../../components/Components/Message/Colors";

  import MessageBodyOnly from "./../../components/Components/Message/MessageBodyOnly";
  import MessageBodyOnlyCode from "!raw-loader!./../../components/Components/Message/MessageBodyOnly";

  import Sizes from "./../../components/Components/Message/Sizes";
  import SizesCode from "!raw-loader!./../../components/Components/Message/Sizes";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Message',
      }
    },
    computed: {
      MessageCode() {
        return MessageCode
      },
      ColorsCode() {
        return ColorsCode
      },
      MessageBodyOnlyCode() {
        return MessageBodyOnlyCode
      },
      SizesCode() {
        return SizesCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Message,
      Colors,
      MessageBodyOnly,
      Sizes,
    },
    methods:{
    },

  }
</script>
