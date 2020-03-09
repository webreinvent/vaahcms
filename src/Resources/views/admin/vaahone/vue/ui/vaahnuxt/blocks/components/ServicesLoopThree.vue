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

        <div v-if="content.features"
             v-for="(feature,index) in content.features">

          <div v-if="index%2==0" class="columns">
            <div class="column is-6">
              <div class="max-box">
                <h2 class="title is-3">{{feature.heading}}</h2>
                <p class="content">{{feature.details}}</p>
                <ul v-if="feature.list" v-for="item in feature.list" class="mt-4">
                  <li class="content">{{item.items}}</li>
                </ul>
                <p class="content">{{feature.details_one}}</p>
                <ul v-if="feature.lists" v-for="itema in feature.lists">
                  <li class="content">{{itema.items}}</li>
                </ul>
              </div>
            </div>
            <div class="column is-5 column is-5 ml-auto m-t-40 m-b-40"> <img :src=feature.src alt="wrapkit" class="img-responsive"> </div>
          </div>
          <div v-else class="columns">
            <div class="column is-5 column is-5 m-t-40 m-b-40"> <img :src=feature.src alt="wrapkit" class="img-responsive"> </div>
            <div class="column is-6 m-t-40 m-b-40">
              <div class="max-box m-t-40 m-b-40">
                <h2 class="title is-3">{{feature.heading}}</h2>
                <p class="content">{{feature.details}}</p>
                <ul v-if="feature.list" v-for="item in feature.list" class="mt-4">
                  <li class="content">{{item.items}}</li>
                </ul>
                <p class="content">{{feature.details_one}}</p>
                <ul v-if="feature.lists" v-for="itema in feature.lists" class="duo-list">
                  <li class="content">{{itema.items}}</li>
                </ul>
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

<style scoped>
  .duo-list{
    list-style: square;
  }
</style>
