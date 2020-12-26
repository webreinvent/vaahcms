<template>
  <div class="spacer ServicesLoopBackgroundImageAndBoxes">
    <div class="feature46" style="background-image:url('https://via.placeholder.com/1920x1080');">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-10 has-text-centered">
            <h2 class="title is-1">{{content.main_heading}}</h2>
            <h6 class="subtitle is-6">{{content.sub_text}}</h6>
          </div>
        </div>
        <div class="columns ">
          <div v-if="content.features" v-for="feature in content.features" class="column is-4">
            <div class="card card-shadow aos-init" data-aos="fade-right" data-aos-duration="1200">
              <div class="card-content p-30">
                <h6 class="title is-4">{{feature.heading}}</h6>
                <p class="content">{{feature.details}}</p>
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

