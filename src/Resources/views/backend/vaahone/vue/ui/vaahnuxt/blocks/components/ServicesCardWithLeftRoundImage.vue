<template>
  <div class="has-background-light spacer ServicesCardWithLeftRoundImage">
    <div class="container">
      <!-- columns  -->
      <div class="columns is-centered">
        <div class="column is-10 has-text-centered">
          <h2 class="title is-1">{{content.main_heading}}</h2>
          <h6 class="subtitle is-6">{{content.sub_text}}</h6>
        </div>
      </div>
      <!-- columns  -->
      <div class="columns mt-5">
        <!-- Column  -->
        <div v-if="content.features"
             v-for="feature in content.features" class="column is-6 mt-5" data-aos="fade-right" data-aos-duration="1200">
          <!-- card  -->
          <div class="card">
            <div class="columns card-content">
              <div class="column is-2 icon-position pr-2">
                <div class="vmdl">
                  <nuxt-link :to="feature.link">
                    <img :src="feature.src" class="round-image image-fluid" alt="">
                  </nuxt-link>
                </div>
              </div>
              <div class="column is-10 pl-0">
                <nuxt-link :to="feature.link">
                  <div class="card-body">
                    <h4 class="title is-4 has-text-dark">{{feature.heading}}</h4>
                    <p class="content has-text-dark">{{feature.details}}</p>
                  </div>
                </nuxt-link>
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


