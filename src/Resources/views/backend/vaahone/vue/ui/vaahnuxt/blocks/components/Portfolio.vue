<template>
  <div class="spacer">
    <div class="container">
      <div class="columns is-centered">
        <div class="column is-10 has-text-centered">
          <h2 class="title">{{content.heading}}</h2>
          <h6 class="subtitle">{{content.details}}</h6>
        </div>
      </div>
      <div class="columns">
        <div v-if="content.folio" v-for="items in content.folio" class="column is-4">
          <div class="card">
            <div class="card-image">
              <figure class="image is-4by3">
                <img :src="items.src" alt="Placeholder image">
              </figure>
            </div>
            <div class="card-content">
              <div class="media">
                <div class="media-content">
                  <p class="title is-4">{{items.name}}</p>
                  <p class="subtitle is-6">{{items.details}}</p>
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


