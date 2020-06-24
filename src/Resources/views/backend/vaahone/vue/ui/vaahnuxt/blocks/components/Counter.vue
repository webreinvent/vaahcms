<template>
  <div>
    <div class="spacer has-background-primary">
      <div class="container">
        <div class="columns is-centered">
          <!-- column  -->
          <div v-if="content.counter" v-for="item in content.counter" class="column is-3-desktop column is-6-tablet">
            <div class="d-flex no-block has-text-white has-text-centered">
              <div class="display-5"><i class="icon-Eyeglasses-Smiley"></i></div>
              <div class="m-l-20">
                <h1 class="font-light counter m-b-0" style="font-size: 42px; text-align: center">{{item.number}}</h1>
                <h6 class="text-muted font-13 has-text-uppercase">{{item.details}}</h6>
              </div>
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

