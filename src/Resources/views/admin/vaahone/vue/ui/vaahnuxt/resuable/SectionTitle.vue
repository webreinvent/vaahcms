<template>

  <div class="container">
    <div class="columns">
      <div class="column">
        <section class="section">

          <div class="columns">
            <div class="column">
              <h1 class="title">{{title}}</h1>
            </div>
          </div>

          <div class="columns is-mobile">

            <div class="column">
              <b-notification aria-close-label="Close notification">
                Complete documentation is at:
                <b-button tag="a" target="_blank"
                          outlined
                          type="is-text"
                          :href="link"
                          size="is-small">
                  Read More
                </b-button>

              </b-notification>
            </div>

          </div>
        </section>

      </div>
    </div>
  </div>


</template>

<script>

  export default {
    props: ['title', 'link'],
    components:{
    },
    data(){

      let obj = {};

      return obj;

    }
  }
</script>

<style scoped>

</style>
