<template>
  <div class="form-page-v1-layout has-background-light has-padding-top-80 has-padding-bottom-80">

    <div class="container">
      <div class="columns is-flex align-items-center has-text-centered justify-center">
        <div class="column is-10">
          <img src="/images/vaah-dev-logo.png" class="is-rounded">
          <div class="steps has-margin-top-50">
            <ul class="has-text-left-mobile">
              <li class="is-inline-block-tablet has-margin-right-30-desktop">
                <ul>
                  <li class="is-inline-block has-background-primary is-rounded has-padding-5">
                    <span class="has-text-white">01</span>
                  </li>
                  <li class="is-inline-block">
                    App & Database Details
                  </li>
                </ul>
              </li>
              <li class="is-inline-block-tablet has-margin-right-30-desktop">
                <ul>
                  <li class="is-inline-block has-background-info is-rounded has-padding-5">
                    <span class="has-text-white">02</span>
                  </li>
                  <li class="is-inline-block">
                    Run Migrations
                  </li>
                </ul>
              </li>
              <li class="is-inline-block-tablet has-margin-right-30-desktop">
                <ul>
                  <li class="is-inline-block has-background-primary is-rounded has-padding-5">
                    <span class="has-text-white">03</span>
                  </li>
                  <li class="is-inline-block">
                    CMS Setup
                  </li>
                </ul>
              </li>
              <li class="is-inline-block-tablet">
                <ul>
                  <li class="is-inline-block has-background-primary is-rounded has-padding-5">
                    <span class="has-text-white">04</span>
                  </li>
                  <li class="is-inline-block">
                    Create Admin Account
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <div class="columns is-flex align-items-center">
            <div class="column is-12 has-margin-right-auto has-margin-left-auto has-margin-top-40">
              <div class="box has-padding-70-tablet">
                <div class="columns">
                  <div class="column is-12">
                    <img src="/images/form-page-v2.png">
                    <b-message class="has-text-centered has-margin-top-20" type="is-warning">
                      This step will download required modules and themes.
                    </b-message>
                  </div>
                </div>
                <button class="button is-primary has-margin-top-20 has-width-150">Run Migrations</button>
                <div class="copyright-text has-margin-top-40">
                  <p>&copy; vaahCMS v2.0 Developed by <a href="#">webreinvent.com</a></p>
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


