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
                  <li class="is-inline-block has-background-primary is-rounded has-padding-5">
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
                  <li class="is-inline-block has-background-info is-rounded has-padding-5">
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
                  <div class="column is-6 has-text-left">
                    <b-field label="First Name">
                      <b-input placeholder="Your First Name"></b-input>
                    </b-field>
                    <b-field label="Email">
                      <b-input placeholder="Email Address"></b-input>
                    </b-field>
                    <b-field label="Username">
                      <b-input placeholder="Username"></b-input>
                    </b-field>
                  </div>
                  <div class="column is-6 has-text-left">
                    <b-field label="Last Name">
                      <b-input placeholder="Your Last Name"></b-input>
                    </b-field>
                    <div class="field-label is-normal has-text-left">
                      <label class="label">Contact Number</label>
                    </div>
                    <div class="field has-addons has-full-width">
                      <p class="control">
                      <span class="select">
                        <select>
                          <option>+91</option>
                          <option>+1</option>
                          <option>+61</option>
                        </select>
                      </span>
                      </p>
                      <p class="control has-margin-left-5 is-full-width">
                        <input class="input" type="text" placeholder="Contact Number">
                      </p>
                    </div>
                    <b-field label="Password">
                      <b-input type="password"
                               placeholder="Password"
                               password-reveal>
                      </b-input>
                    </b-field>
                  </div>
                </div>
                <button class="button is-primary has-margin-top-20 has-width-150">Submit</button>
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


