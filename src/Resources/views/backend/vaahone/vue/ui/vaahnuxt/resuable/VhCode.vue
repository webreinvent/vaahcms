<template>

  <div class="vh-code">

    <pre v-highlightjs><code :class="language"><slot/></code></pre>

  </div>



</template>

<script>

  export default
  {
    props: ['language'],
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
