<template>

  <div>

    <div class="columns">
      <div class="column has-text-centered">


        <div class="level">

          <div class="level-item has-text-centered">
            <div>
              <nuxt-link to="/ui/buefy">Buefy</nuxt-link>
              | <nuxt-link to="/ui/bulma">Bulma</nuxt-link>
              | <nuxt-link to="/ui/docs">Docs</nuxt-link>
              | <nuxt-link to="/ui/blocks">Blocks</nuxt-link>
            </div>
          </div>

        </div>

        <div class="versions ">

          <b-tag>{{pkg.name}} v{{pkg.version}}</b-tag>
          <b-tag>{{buefy.name}} v{{buefy.version}}</b-tag>
          <b-tag>{{bulma.name}} v{{bulma.version}}</b-tag>

        </div>

      </div>
    </div>



  </div>

</template>

<script>
  import pkg from './../../package';
  import buefy from './../../node_modules/buefy/package';
  import bulma from './../../node_modules/bulma/package';
  export default {
    components:{
    },
    data(){
      let obj = {
        pkg: pkg,
        buefy: buefy,
        bulma: bulma,
      }
      return obj;
    }
  }
</script>

<style scoped>

</style>
