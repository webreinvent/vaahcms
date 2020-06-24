<template>

  <div class="vh-command">

    <article class="message">
      <div class="message-body has-padding-10">

        <div class="level is-flex">

          <div class="level-left">
            {{command}}
          </div>

          <div class="level-right is-top-marginless">
            <b-button type="is-text" size="is-small">



              <vh-copy
                :data="command"
                label=""
                :confirm_dialog="'buefy'"
                class="content has-text-right ">
                <b-icon size="is-small" icon="align-justify"></b-icon>
              </vh-copy>

            </b-button>
          </div>


        </div>


      </div>
    </article>





  </div>



</template>

<script>

  export default {
    props: ['command'],
    components:{
    },
    data(){

      let obj = {};

      return obj;

    }
  }
</script>

<style scoped>

</style>
