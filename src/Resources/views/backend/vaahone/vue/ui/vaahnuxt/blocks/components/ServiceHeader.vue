<template>
  <section class="section spacer">
    <div class="container">
      <div class="columns">
        <div class="column is-6">
          <h1 class="has-text-dark title is-4"><strong>{{content.heading}}</strong></h1>
          <p class="content">{{content.details}}</p>
        </div>
        <div class="column is-6">
          <div class="columns">
            <div class="column">
              <b-field>
                <b-input value="First Name"></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field>
                <b-input value="Last Name"></b-input>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-field>
                <b-input value="Email"></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field>
                <b-input value="Phone"></b-input>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-field>
                <b-input value="Subject"></b-input>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-field>
                <b-input value="Message" maxlength="200" type="textarea"></b-input>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <button class="button is-primary is-fullwidth">Send</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>


  export default {
    props: ['content']
  }
</script>


