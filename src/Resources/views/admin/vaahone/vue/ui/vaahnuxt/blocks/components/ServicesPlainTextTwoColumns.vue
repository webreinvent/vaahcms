<template>

  <div>
    <div class="spacer feature4 ServicesPlainTextTwoColumns" style="background:#f3f3f3;">
      <div class="container">
        <!-- columns  -->
        <div class="columns is-centered">
          <div class="column is-10 has-text-centered">
            <h2 class="title is-1">{{content.main_heading}}</h2>
            <h6 class="subtitle is-6">{{content.sub_text}}</h6>
          </div>
        </div>
        <!-- columns  -->
        <div class="columns m-t-40">
          <!-- Column -->
          <div v-if="content.features"
               v-for="feature in content.features" class="column is-6 wrap-feature4-box">
            <div class="card aos-init mt-5" data-aos="zoom-out-right" data-aos-duration="1200">
              <div class="card-content">
                <div class="icon-round has-background-light-info"><img :src="feature.src" class="round-image" alt=""></div>
                <h5 class="title is-4">{{feature.heading}}</h5>
                <p class="content">{{feature.details}}</p>
              </div>
            </div>
          </div>
          <!-- Column -->
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
