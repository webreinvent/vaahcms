<template>
  <div>
    <div class="spacer has-background-light team1">
      <div class="container">
        <div class="columns is-centered m-b-30">
          <div class="column is-7 has-text-centered">
            <h2 class="title is-1">{{content.heading}}</h2>
            <h6 class="subtitle is-6">{{content.details}}</h6>
          </div>
        </div>
        <div class="columns m-t-30">
          <!-- column  -->
          <div v-if="content.team" v-for="items in content.team" class="column is-6">
            <div class="card card-shadow">
              <!-- columns -->
              <div class="columns no-gutters ">
                <div class="column is-5 pro-pic">
                  <img :src="items.src" class="img-fluid is-centered d-block" alt="">
                </div>
                <div class="column is-7 bg-white">
                  <div class="p-30">
                    <h5 class="title is-4 m-t-0 font-medium">{{items.name}}</h5>
                    <p class="content">{{items.designation}}</p>
                  </div>
                </div>
              </div>
              <!-- columns -->
            </div>
          </div>
          <!-- column  -->
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

