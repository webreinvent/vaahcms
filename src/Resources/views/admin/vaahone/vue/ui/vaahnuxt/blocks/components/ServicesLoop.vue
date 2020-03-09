<template class=" spacer">
  <div class=" has-background-light spacer">
    <div class="container">
      <!-- Row  -->
      <div class="columns is-centered">
        <div class="column is-10 has-text-centered">
          <h2 class="title is-1">{{content.main_heading}}</h2>
          <h6 class="subtitle is-6">{{content.sub_text}}</h6>
        </div>
      </div>
      <!-- Row  -->
      <div class="columns m-t-40">
        <!-- Column -->
        <div v-if="content.features"
             v-for="feature in content.features"
             class="column is-4 wrap-feature2-box">


          <div class="card card-shadow" data-aos="flip-left" data-aos-duration="1200">
            <img class="card-img-top" :src=feature.src alt="wrappixel kit" />
            <div class="card-content has-text-centered">
              <h5 class="title is-4">{{feature.heading}}</h5>
              <p class="content">{{feature.details}}</p>
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


