<template>
  <div class="spacer">
    <div class="has-background-light">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-10 has-text-centered">
            <h2 class="title is-1">{{content.main_heading}}</h2>
            <h6 class="subtitle is-6">{{content.sub_text}}</h6>
          </div>
        </div>
        <div class="columns m-t-40">
          <!-- Column -->
          <div class="column is-6 wrap-feature15-box">
            <div class="columns">
              <div v-if="content.features"
                   v-for="feature in content.features" class="column is-12" data-aos="fade-down" data-aos-duration="1000">
                <div class="">
                  <div>
                    <h5 class="title is-3">{{feature.heading}}</h5>
                    <p class="content">{{feature.details}}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Column -->
          <div class="column is-6 wrap-feature15-box" data-aos="flip-left" data-aos-duration="1200">
            <img src="https://via.placeholder.com/485x450" class="img-responsive" alt="wrapkit" />
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


