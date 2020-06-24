<template>
  <nav class="navbar zindex" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">

      <vaah-link to="/ui/blocks" class="navbar-item">
        UI Blocks
      </vaah-link>


      <a role="button" class="navbar-burger burger" aria-label="menu"
         aria-expanded="false" data-target="navbarUIBlocks">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>

    </div>

    <div id="navbarUIBlocks" class="navbar-menu">
      <div class="navbar-start">

        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            Blocks
          </a>

          <div class="navbar-dropdown">
            <vaah-link to="/ui/blocks" class="navbar-item">Page 1</vaah-link>
            <vaah-link to="/ui/blocks/others" class="navbar-item">Page 2</vaah-link>
          </div>
        </div>

        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            Cards
          </a>

          <div class="navbar-dropdown">
            <vaah-link to="/ui/blocks/cards" class="navbar-item">Page 1</vaah-link>
            <vaah-link to="/ui/blocks/cards-two" class="navbar-item">Page 2</vaah-link>
          </div>
        </div>

        <vaah-link to="/ui/blocks/banner" class="navbar-item">Banner</vaah-link>
        <vaah-link to="/ui/blocks/pricing" class="navbar-item">Pricing</vaah-link>
        <vaah-link to="/ui/blocks/tabs" class="navbar-item">Tabs & Pills</vaah-link>
        <vaah-link to="/ui/blocks/calltoactions" class="navbar-item">Call To Actions</vaah-link>
        <vaah-link to="/ui/blocks/forms" class="navbar-item">Forms</vaah-link>
        <vaah-link to="/ui/blocks/blogs" class="navbar-item">Blogs</vaah-link>
        <vaah-link to="/ui/blocks/clientele" class="navbar-item">Clientele</vaah-link>
        <vaah-link to="/ui/blocks/faq" class="navbar-item">FAQ</vaah-link>
        <vaah-link to="/ui/blocks/list" class="navbar-item">List</vaah-link>
        <vaah-link to="/ui/blocks/testimonials" class="navbar-item">Testimonials</vaah-link>
        <vaah-link to="/ui/blocks/counter" class="navbar-item">Counter</vaah-link>
        <vaah-link to="/ui/blocks/process" class="navbar-item">Process</vaah-link>
        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            More
          </a>

          <div class="navbar-dropdown">
            <vaah-link to="/ui/blocks/team" class="navbar-item">Team</vaah-link>
            <vaah-link to="/ui/blocks/portfolio" class="navbar-item">Portfolio</vaah-link>
            <vaah-link to="/ui/blocks/cheatsheet" class="navbar-item">Cheatsheet</vaah-link>
          </div>
        </div>



      </div>


    </div>
  </nav>

</template>

<script>
  import globalComponents from '../../helpers/globalComponents'
  export default {
    data() {
      return {

      }
    },
    components:{
      ...globalComponents,
    },
  }
</script>
<style>
  .zindex{
    z-index: 10;
  }
  .zindex .navbar-brand{
    font-weight: 700;
    text-transform: uppercase;
  }
</style>
