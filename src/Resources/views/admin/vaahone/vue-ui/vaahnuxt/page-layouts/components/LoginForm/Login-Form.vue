<template>
  <div class="login-form-layout">

    <div class="container">
      <div class="columns is-flex align-items-center justify-center">
        <div class="column is-5">
          <div class="login-box box is-flex flex-column align-items-center has-text-centered justify-center">
            <img src="/images/vaah-dev-logo.png">
            <div class="content has-text-centered has-margin-top-20">
              <h3 class="title">Sign In</h3>
              <p class="subtitle">Welcome back! Please signin to continue</p>
            </div>
            <b-field class="is-full-width has-margin-top-20">
              <b-input type="email"
                       placeholder="Enter Email Address"
                       maxlength="30">
              </b-input>
            </b-field>
            <b-field class="is-full-width">
              <b-input type="password"
                       placeholder="Enter Password"
                       password-reveal>
              </b-input>
            </b-field>
            <div class="buttons is-full-width has-margin-top-20">
              <div class="columns is-full-width">
                <div class="column">
                  <button class="button is-primary is-pulled-left is-full-width">Sign In</button>
                </div>
                <div class="column has-text-right-desktop">
                  <a href="#">Forgot Password?</a>
                </div>
              </div>
            </div>
            <div class="or  has-margin-top-10 is-full-width">
              <div class="columns">
                <div class="column">
                  <hr>
                </div>
                <div class="column is-1">
                  <p class="has-margin-top-10">or</p>
                </div>
                <div class="column">
                  <hr>
                </div>
              </div>
            </div>
            <div class="social-links">
              <ul>
                <li class="is-inline-block has-background-primary has-padding-10 is-rounded has-margin-right-20">
                  <a href="#">
                    <b-icon
                      icon="facebook"
                      size="is-medium" class="has-text-white">
                    </b-icon>
                  </a>
                </li>
                <li class="is-inline-block has-background-info has-padding-10 is-rounded has-margin-right-20">
                  <a href="#">
                    <b-icon
                      icon="twitter"
                      size="is-medium" class="has-text-white">
                    </b-icon>
                  </a>
                </li>
                <li class="is-inline-block has-background-danger has-padding-10 is-rounded">
                  <a href="#">
                    <b-icon
                      icon="instagram"
                      size="is-medium" class="has-text-white">
                    </b-icon>
                  </a>
                </li>
              </ul>
            </div>
            <div class="copyright-text has-margin-top-40">
              <p>&copy; 2019. VaahCMS v2.0</p>
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


