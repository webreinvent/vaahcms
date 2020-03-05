<template>
  <div>
    <div class="blogs spacer">
      <div class="container">
        <div class="columns is-centered">
          <div class="column">
            <h2 class="title is-1 has-text-centered">{{content.heading}}</h2>
            <h6 class="subtitle is-6 has-text-centered">{{content.details}}</h6>
          </div>
        </div>
        <div class="columns">
          <div v-for="(items, index) in content.blog" v-if="index==0" class="column is-half">
            <div class="card">
              <div class="card-image">
                <figure class="image is-4by3">
                  <img :src="items.src" alt="Placeholder image">
                </figure>
              </div>
              <div class="card-content">
                <div class="media">
                  <div class="media-content">
                    <p class="content">{{items.name}},&nbsp; &nbsp; {{items.date}}</p>
                  </div>
                </div>

                <div class="content">
                  <h2 class="title is-4">{{items.heading}}</h2>
                  <p class="content">{{items.details}}</p>
                  <br>
                </div>
              </div>
            </div>
          </div>
          <div class="column is-half is-desktop">
            <div class="columns" style="flex-wrap: wrap;">
              <div v-for="(items, index) in content.blog" v-if="index > 0 && index <= 4" class="column is-6">
                <div class="card">
                  <div class="card-image">
                    <figure class="image is-4by3">
                      <img :src="items.src" alt="Placeholder image">
                    </figure>
                  </div>
                  <div class="card-content">
                    <div class="media" style="margin-bottom: 0px;">
                      <div class="media-content">
                        <p class="content is-4">{{items.name}},&nbsp; &nbsp; {{items.date}}</p>
                      </div>
                    </div>

                    <div class="content">
                      <h4 class="title is-4" style="margin-bottom: 0px;">{{items.heading}}</h4>
                      <br>
                    </div>
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


