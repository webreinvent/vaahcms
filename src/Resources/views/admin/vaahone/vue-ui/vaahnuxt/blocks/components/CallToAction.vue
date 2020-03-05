<template>
  <section class="section has-background-primary">
    <div class="container">
      <div class="columns card-content">
        <div class="column is-10">
          <h1><strong class="has-text-white is-4 title">{{content.details_one}}</strong></h1>
        </div>
        <div class="column is-2 has-text-centered">
          <nuxt-link  v-if="content.link" class="button is-danger is-medium" to="/contact">
            {{content.link.label}} <i class="ti-arrow-right"></i>
          </nuxt-link>
        </div>
      </div>
    </div>
  </section>
</template>

<script>


  export default {
    props: ['content']
  }
</script>


