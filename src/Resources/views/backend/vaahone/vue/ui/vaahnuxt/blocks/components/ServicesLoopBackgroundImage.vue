<template>
  <div class="spacer ServicesLoopBackgroundImage">
    <div class="wrap-feature36-box" style="background-image:url('https://via.placeholder.com/1920x1080');">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-10 has-text-centered">
            <h2 class="title is-1">{{content.main_heading}}</h2>
            <h6 class="subtitle is-6">{{content.sub_text}}</h6>
          </div>
        </div>
        <div class="columns ">
          <div v-if="content.services" v-for="service in content.services" class="column is-4 m-t-40">
            <h3 class="title is-4">{{service.heading}}</h3>
            <p class="content">{{service.details}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>


  export default {
    props: ['content']
  }
</script>
<style scoped>

</style>

