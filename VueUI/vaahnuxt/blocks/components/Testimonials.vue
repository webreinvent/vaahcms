<template>
  <div class="Testimonials">
    <div class="testimonial1 spacer has-background-light">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-7 has-text-centered">
            <h2 class="title">{{content.heading}}</h2>
            <h6 class="subtitle">{{content.details}}</h6>
          </div>
        </div>
        <!-- columns  -->
        <div class="columns">
          <div v-if="content.testi" v-for="items in content.testi" class="column is-6 mt-5">
            <div class="card card-shadow">
              <div class="card-body">
                <div class="thumb bg-success-gradiant"><img :src="items.src" alt="wrapkit" class="thumb-img round-image">{{items.name}}</div>
                <h5 class="font-light">{{items.details}}</h5>
                <span class="devider"></span>
                <h6>{{items.designation}}</h6>
              </div>
            </div>
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

