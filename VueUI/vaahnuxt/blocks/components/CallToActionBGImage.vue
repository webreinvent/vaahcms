<template>
  <section class="section spacer"  style="background-image:url('https://via.placeholder.com/1970x796');">
    <div class="container">
      <div class="columns is-centered">
        <div class="column is-10 has-text-centered">
          <h1><strong class="has-text-white is-4 title">{{content.heading}}</strong></h1>
          <p><strong class="has-text-white content">{{content.details}}</strong></p>
        </div>
      </div>
      <div class="columns is-centered">
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


