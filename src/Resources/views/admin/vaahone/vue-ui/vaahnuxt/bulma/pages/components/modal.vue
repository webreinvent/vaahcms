<template>

  <div>

    <TopMenu></TopMenu>
    <BulmaTopMenu></BulmaTopMenu>
    <PageHeader></PageHeader>

    <div class="main-content">


      <SectionCode name="Modal" :code="ModalCode">
        <Modal></Modal>
      </SectionCode>


      <SectionCode name="Image Modal" :code="ImageModalCode">
        <ImageModal></ImageModal>
      </SectionCode>


      <SectionCode name="Modal Card" :code="ModalCardCode">
        <ModalCard></ModalCard>
      </SectionCode>


    </div>

    <Footer></Footer>

  </div>

</template>

<script>

  import globalComponents from "./../../../helpers/globalComponents";
  import BulmaTopMenu from "./../../../bulma/partials/BulmaTopMenu";

  import Modal from "./../../components/Components/Modal/Modal";
  import ModalCode from "!raw-loader!./../../components/Components/Modal/Modal";

  import ImageModal from "./../../components/Components/Modal/ImageModal";
  import ImageModalCode from "!raw-loader!./../../components/Components/Modal/ImageModal";

  import ModalCard from "./../../components/Components/Modal/ModalCard";
  import ModalCardCode from "!raw-loader!./../../components/Components/Modal/ModalCard";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'Bulma UI components- Modal',
      }
    },
    computed: {
      ModalCode() {
        return ModalCode
      },
      ImageModalCode() {
        return ImageModalCode
      },
      ModalCardCode() {
        return ModalCardCode
      },
    },
    components: {
      ...globalComponents,
      BulmaTopMenu,
      Modal,
      ImageModal,
      ModalCard,
    },
    methods:{
    },

  }
</script>
