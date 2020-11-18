<template>
  <section class="section has-background-success">
    <div class="container">
      <div class="columns card-content">
        <div class="column has-text-centered">
          <h1><strong class="has-text-white title is-4">{{content.details_one}}</strong></h1>
        </div>
      </div>
    </div>
  </section>
</template>

<script>


  export default {
    props: ['content']
  }
</script>


