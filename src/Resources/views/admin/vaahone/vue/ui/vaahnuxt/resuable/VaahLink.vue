<template>


    <nuxt-link v-if="link_type==='nuxt'" :to="to"><slot></slot></nuxt-link>
    <router-link v-else :to="to"><slot></slot></router-link>


</template>

<script>
  export default {
    props: ['to'],
    computed:{
      root() {return this.$store.getters['root/state']},
      link_type() {return this.$store.getters['root/state'].link_type},
    },
    components:{

    },
    data () {
      return {
      }
    },
    watch: {

    },
    template: `
      <nuxt-link v-if="link_type==='nuxt'" :to="to"><slot></slot></nuxt-link>
      <router-link v-else :to="to"><slot></slot></router-link>
  `,
  }
</script>
