<template>

  <div class="docs code">

    <div class="box has-margin-bottom-10">

    <div class="level is-paddingless" v-bind:class="{'has-bottom-border': title}">

      <div class="level-left">

        <div class="level-item">
          <small style="font-weight: 600;">{{title}}</small>
        </div>

      </div>

      <div class="level-right">

        <div class="level-item">
          <vh-copy
            class="has-padding-right-5"
            :data="code"
            :label="'copy'"
            :confirm_dialog="'buefy'">

          </vh-copy>
        </div>

      </div>

    </div>

    <pre class="is-paddingless" v-highlightjs="code"><code class="vue"></code></pre>

    </div>

  </div>

</template>

<script>

  export default {
    props: ['title', 'code'],
    components:{
    },
    data(){

      let obj = {
        link: null,
      };

      return obj;

    },
    mounted () {

    },
    methods:{

    }
  }
</script>

<style scoped>
  .tab-content{
    padding: 10px 0px;
  }
</style>
