<template>
  <div class="spacer ServiceFeaturesListViewCenterImage">
    <div class="container">
      <!-- columns  -->
      <div class="columns is-centered">
        <div class="column is-10 has-text-centered">
          <h2 class="title">{{content.main_heading}}</h2>
          <h6 class="subtitle">{{content.sub_text}}</h6>
        </div>
      </div>
      <!-- columns  -->
      <div class="columns m-t-40">
        <div class="column is-3">
          <div  v-for="(feature, index) in content.features">
            <div v-if="index%2==0" class="card mt-5 pl-2">
              <div class="columns is-gapless">
                <div class="column is-8 pr-0">
                  <div class="card-body has-text-right p-0 vmdl">
                    <h4 class="font-medium">{{feature.heading}}</h4>
                    <p class="text-dark">{{feature.details}}</p>
                  </div>
                </div>
                <div class="column is-4 icon-position pr-2">
                  <div>
                    <img :src="feature.src" class="round-image image-fluid" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="column is-6">
          <div class="mt-5">
            <img :src="content.src" class="image-fluid is-centered d-block" alt="">
          </div>
        </div>
        <div class="column is-3 pl-0">
          <div v-for="(feature, index) in content.features">
            <div v-if="index%2!=0" class="card mt-5 pl-2">
              <div class="columns">
                <div class="column is-4 icon-position pr-2">
                  <div>
                    <img :src="feature.src" class="round-image image-fluid" alt="">
                  </div>
                </div>
                <div class="column is-8 pl-0">
                  <div class="card-body p-0 vmdl">
                    <h4 class="font-medium">{{feature.heading}}</h4>
                    <p class="text-dark">{{feature.details}}</p>
                  </div>
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


