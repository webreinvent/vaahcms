<template>
  <section>
    <b-checkbox v-model="isGreen">Green color</b-checkbox>

    <div class="block">
      <b-icon :type="{ 'is-success': isGreen }" icon="address-book"></b-icon>
      <b-icon :type="{ 'is-success': isGreen }" icon="home"></b-icon>
      <b-icon :type="{ 'is-success': isGreen }" icon="tachometer-alt"></b-icon>
    </div>
  </section>
</template>

<script>
  export default {
    data() {
      return {
        isGreen: true
      }
    }
  }
</script>
