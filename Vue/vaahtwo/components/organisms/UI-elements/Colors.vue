<template>
  <h5>Colors</h5>
  <div class="grid">
    <Fluid class="col-12">
      <div class="grid m-10 mb-10" v-for="(item,index) in colors" :key="index">
        <div class="col">
          <div class="color-sample-box" :class="item"></div>
          <h6 class="mt-1 capitalize">{{item}}</h6>
        </div>
        <div class="col">
          <div class="vc-shade-lighter color-sample-box" :class="item"></div>
          <h6 class="mt-1 capitalize">{{item}} lighter</h6>
        </div>
        <div class="col">
          <div class="vc-shade-light color-sample-box" :class="item"></div>
          <h6 class="mt-1 capitalize">{{item}} Light</h6>
        </div>
        <div class="col">
          <div class="vc-shade-dark color-sample-box" :class="item"></div>
          <h6 class="mt-1 capitalize">{{item}} Dark</h6>
        </div>
        <div class="col">
          <div class="vc-shade-darker color-sample-box" :class="item"></div>
          <h6 class="mt-1 capitalize">{{item}} Darker</h6>
        </div>
      </div>
    </Fluid>
  </div>
</template>

<script>
export default {
  name: "Colors",
  data(){
    return{
        color: '#dadadada',
      colors:[
        'primary',
        'secondary',
        'info',
        'success',
        'danger',
        'warning',
        'help'
      ],
    }
  },
}
</script>

<style scoped>

</style>