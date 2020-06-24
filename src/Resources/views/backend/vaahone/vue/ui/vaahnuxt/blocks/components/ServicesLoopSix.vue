<template>
  <div>
    <div class="has-background-light spacer">
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
          <div v-if="content.features"
               v-for="feature in content.features"
               class="column is-6 wrap-feature3-box">

            <div class="card card-shadow" data-aos="fade-right" data-aos-duration="1200">
              <div class="card-body d-flex">
                <div class="align-self-center card-content">
                  <h5 class="title is-4">{{feature.heading}}</h5>
                  <p class="content">{{feature.details}}</p>
                  <div class="columns">
                    <div v-if="feature.list"
                         v-for="item in feature.list" class="column is-6">
                      <ul class="list_pad">
                        <li class="content">{{item.items}}</li>
                      </ul>
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


