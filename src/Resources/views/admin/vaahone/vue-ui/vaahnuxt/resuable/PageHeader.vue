<template>

  <section class="hero is-primary">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">
          UI Blocks - {{page_name}}
        </h1>
        <h2 class="subtitle">
          Reference for UI Blocks Future:
          <a target="_blank" href="https://www.froala.com/design-blocks">view</a>
        </h2>
      </div>
    </div>
  </section>





</template>

<script>


  export default {
    components:{

    },

    data () {
      return {
        page_name: null
      }
    },
    watch: {
      $route(to, from) {
        this.setPageName(to.fullPath);
      },
    },

    mounted() {
      this.setPageName(this.$route.fullPath);
    },

    methods: {
      setPageName: function (fullPath) {
        this.page_name = this.$vaah.getPageName(fullPath);
        this.page_name = this.$vaah.ucfirst(this.page_name);
      }
    }

  }
</script>
