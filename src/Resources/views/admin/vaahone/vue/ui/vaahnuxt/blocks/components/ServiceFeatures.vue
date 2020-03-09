<template>
  <div class="has-background-light spacer">
    <div class="container">
      <div class="columns is-centered">
        <div class="column is-10 has-text-centered">
          <h2 class="title is-1">{{content.heading}}</h2>
          <h6 class="subtitle is-6">{{content.details}}</h6>
        </div>
      </div>
      <div class="columns">
        <div v-if="content.features"
             v-for="feature in content.features" class="column is-4">
          <div class="card p-3">
            <div class="card-content">
              <h5 class="title is-4">{{feature.title}}</h5>
              <p class="content">{{feature.details}}</p>
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


