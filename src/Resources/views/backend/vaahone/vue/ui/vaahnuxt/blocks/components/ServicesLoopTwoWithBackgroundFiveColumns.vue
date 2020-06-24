<template>

  <div>

    <div class="spacer feature2 has-background-light">
      <div class="container">
        <!-- columns  -->
        <div class="columns is-centered">
          <div class="column is-7 has-text-centered">
            <h2 class="title">{{content.main_heading}}</h2>
            <h6 class="subtitle">{{content.sub_text}}</h6>
          </div>
        </div>
        <!-- columns  -->
        <div class="columns m-t-40">
          <!-- Column -->
          <div v-if="content.features"
               v-for="feature in content.features"
               class="column is-3 wrap-feature1-box">


            <div class="has-background-light aos-init aos-animate p-3" data-aos="fade-left" data-aos-duration="1200">
              <div class="has-background-light has-text-centered">
                <img class="centered-image" :src=feature.src alt="wrappixel kit" />
                <h5 class="font-medium">{{feature.heading}}</h5>
                <p class="m-t-20">{{feature.details}}</p>
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

<style scoped>
  .wrap-feature1-box{
    border: 2px dashed #bd2130;
  }
</style>
