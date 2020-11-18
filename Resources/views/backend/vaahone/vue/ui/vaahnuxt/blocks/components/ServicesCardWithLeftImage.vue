<template>
  <div class="spacer">
    <div class="container">
      <!-- row  -->
      <div class="columns is-centered">
        <div class="column is-10 has-text-centered">
          <h2 class="title is-1">{{content.main_heading}}</h2>
          <h6 class="subtitle is-6">{{content.sub_text}}</h6>
        </div>
      </div>
      <!-- row  -->
      <div class="columns  wrap-feature-18">
        <!-- Column  -->
        <div v-if="content.features"
             v-for="feature in content.features" class="column is-6">
          <!-- card  -->
          <div class="card">
            <div class="columns">
              <div class="column is-5 icon-position pr-2" style="padding: 0px 15px;">
                <img :src="feature.src" class="image-fluid" alt="">
              </div>
              <div class="column is-7">
                <div class="card-body">
                  <h4 class="title is-4">{{feature.heading}}</h4>
                  <p class="content">{{feature.details}}</p>
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


