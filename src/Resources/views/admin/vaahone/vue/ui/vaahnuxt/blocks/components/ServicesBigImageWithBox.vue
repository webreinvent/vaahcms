<template>
  <div class="spacer ServicesBigImageWithBox">
    <div class="container">
      <div class="columns is-centered">
        <div class="column is-10 has-text-centered">
          <h2 class="title is-1">{{content.main_heading}}</h2>
          <h4 class="subtitle is-6">{{content.sub_text}}</h4>
        </div>
      </div>
      <div v-if="content.services" v-for="(service, index) in content.services">
        <div v-if="index%2==0" class="columns feature30">
          <div class="column is-10 is-offset-2"><img :src="service.src" class="image-fluid" alt="wrappixel" /></div>
          <div class="column is-5-desktop is-7-tablet has-text-centered wrap-feature30-box" data-aos="fade-left" data-aos-duration="1800" data-aos-easing="linear">
            <div class="card card-shadow">
              <div class="card-content">
                <div class="p-20">
                  <h3 class="title is-3">{{service.heading}}</h3>
                  <p class="content">{{service.details}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-else class="columns feature30">
          <div class="column is-10 feature_image"><img :src="service.src" class="image-fluid" alt="wrappixel" /></div>
          <div class="column is-5-desktop is-7-tablet has-text-centered wrap-feature30-box1" data-aos="fade-left" data-aos-duration="1800" data-aos-easing="linear">
            <div class="card card-shadow">
              <div class="card-content">
                <div>
                  <h3 class="title is-3">{{service.heading}}</h3>
                  <p class="content">{{service.details}}</p>
                </div>
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


