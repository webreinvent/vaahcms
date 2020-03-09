<template>

  <div>

    <div class="spacer feature2">
      <div class="container">
        <!-- columns  -->
        <div class="columns is-centered">
          <div class="column is-7 has-text-centered">
            <h2 class="title is-1">{{content.main_heading}}</h2>
            <h6 class="subtitle is-6">{{content.sub_text}}</h6>
          </div>
        </div>
        <!-- columns  -->
        <div class="columns m-t-40">
          <!-- Column -->
          <div v-if="content.features"
               v-for="feature in content.features"
               class="column is-4 wrap-feature1-box">


            <div class="card card-shadow aos-init aos-animate" data-aos="fade-left" data-aos-duration="1200">
              <div class="card-content has-text-centered">
                <img class="icon-space" :src=feature.src alt="wrappixel kit" />
                <h5 class="title is-4">{{feature.heading}}</h5>
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
