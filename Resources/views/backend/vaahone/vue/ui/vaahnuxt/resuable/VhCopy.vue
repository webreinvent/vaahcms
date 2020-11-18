<template>

  <b-button type="is-text" size="is-small">

    <b-icon size="is-small"
            v-if="hide_icon === false"
            icon="align-justify"></b-icon>

    <vh-copy
      :data="data"
      :label="copy_label"
      :confirm_dialog="'buefy'"
      class="content has-text-right ">
    </vh-copy>

  </b-button>

</template>

<script>

  export default {
    props: ['data', 'label', 'hide_icon'],
    components:{
    },
    data(){

      let obj = {
        copy_label: "copy"
      };

      return obj;

    },
    mounted() {

      if(this.label){
        this.copy_label = this.label;
      }

    }
  }
</script>

<style scoped>

</style>
