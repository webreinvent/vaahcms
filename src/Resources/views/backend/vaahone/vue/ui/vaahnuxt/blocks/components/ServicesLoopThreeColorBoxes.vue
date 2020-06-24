<template>

  <div class="ServicesLoopThreeColorBoxes">
    <div class="spacer feature6">
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

          <div v-if="content.services"
               v-for="(service, index) in content.services" class="column is-4 wrap-feature6-box">

            <div v-if="index%3==0" class="card bg-success-gradiant has-text-white" data-aos="fade-right" data-aos-duration="1200">
              <div class="card-content">
                <h6 class="title is-4 has-text-white">{{service.heading}}</h6>
                <p class="content has-text-white">{{service.details}}</p>
              </div>
            </div>

            <div v-else-if="index%3==1" class="card bg-info-gradiant has-text-white" data-aos="fade-down" data-aos-duration="1200">
              <div class="card-content">
                <h6 class="title is-4 has-text-white">{{service.heading}}</h6>
                <p class="content has-text-white">{{service.details}}</p>
              </div>
            </div>

            <div v-else-if="index%3==2" class="card bg-danger-gradiant has-text-white" data-aos="fade-left" data-aos-duration="1200">
              <div class="card-content">
                <h6 class="title is-4 has-text-white">{{service.heading}}</h6>
                <p class="content has-text-white">{{service.details}}</p>
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
