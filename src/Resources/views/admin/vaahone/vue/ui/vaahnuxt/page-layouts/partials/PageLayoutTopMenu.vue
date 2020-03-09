<template>
  <nav class="navbar zindex" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">

        <router-link to="/ui/blocks" class="navbar-item">
          Page Layouts
        </router-link>


      <a role="button" class="navbar-burger burger" aria-label="menu"
         aria-expanded="false" data-target="navbarUIBlocks">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>

    </div>

    <div id="navbarUIBlocks" class="navbar-menu">
      <div class="navbar-start">

        <b-tooltip label="Gitlab Similar page Layout" position="is-right">
          <router-link to="/ui/page-layouts/layout-v1" class="navbar-item">Layout-v1</router-link>
        </b-tooltip>
        <b-tooltip label="Login Form page Layout" position="is-right">
          <router-link to="/ui/page-layouts/login-form" class="navbar-item">Login Form</router-link>
        </b-tooltip>
        <b-tooltip label="Vaah CMS Form page Layout" position="is-right">
          <router-link to="/ui/page-layouts/form-page-v1" class="navbar-item">Form Page-v1</router-link>
        </b-tooltip>
        <b-tooltip label="Vaah CMS Form page Layout" position="is-right">
          <router-link to="/ui/page-layouts/form-page-v2" class="navbar-item">Form Page-v2</router-link>
        </b-tooltip>
        <b-tooltip label="Vaah CMS Form page Layout" position="is-right">
          <router-link to="/ui/page-layouts/form-page-v3" class="navbar-item">Form Page-v3</router-link>
        </b-tooltip>
        <b-tooltip label="Vaah CMS Form page Layout" position="is-right">
          <router-link to="/ui/page-layouts/form-page-v4" class="navbar-item">Form Page-v4</router-link>
        </b-tooltip>
        <b-tooltip label="CRM page Layout" position="is-right">
          <router-link to="/ui/page-layouts/crm-page" class="navbar-item">CRM Page</router-link>
        </b-tooltip>
        <b-tooltip label="Point Of Sale page Layout" position="is-right">
          <router-link to="/ui/page-layouts/point-of-sale-page" class="navbar-item">Point Of Sale Page</router-link>
        </b-tooltip>
        <b-tooltip label="App list View page Layout" position="is-left">
          <router-link to="/ui/page-layouts/app-list-view-small" class="navbar-item">App List View Small</router-link>
        </b-tooltip>

        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            More
          </a>

          <div class="navbar-dropdown">
            <router-link to="/ui/page-layouts/post-page" class="navbar-item">Post Page</router-link>
            <b-tooltip label="Post Details Full Width" type="is-light" position="is-left">
              <router-link to="/ui/page-layouts/post-details-v1" class="navbar-item">Post Details-v1</router-link>
            </b-tooltip>
            <b-tooltip label="Post Details Half Width" type="is-light" position="is-left">
              <router-link to="/ui/page-layouts/post-details-v2" class="navbar-item">Post Details-v2</router-link>
            </b-tooltip>
          </div>
        </div>

      </div>


    </div>
  </nav>

</template>

<script>
  export default {
    data() {
      return {

      }
    }
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
