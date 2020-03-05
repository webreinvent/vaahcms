<template>
  <div class="spacer">
    <div class="container">
      <div class="columns is-centered">
        <div class="column is-10 has-text-centered">
          <h2 class="title">{{content.main_heading}}</h2>
          <h6 class="subtitle">{{content.sub_text}}</h6>
        </div>
      </div>
      <div class="columns">
        <div class="column">
          <b-collapse
            class="card"
            v-for="(faq, index) of content.freq"
            :key="index"
            :open="isOpen == index"
            @open="isOpen = index">
            <div
              slot="trigger"
              slot-scope="props"
              class="card-header"
              role="button">
              <p class="card-header-title">
                {{ faq.heading }}
              </p>
              <a class="card-header-icon">
                <b-icon
                  :icon="props.open ? 'menu-down' : 'menu-up'">
                </b-icon>
              </a>
            </div>
            <div class="card-content">
              <div class="content">
                {{ faq.body }}
              </div>
            </div>
          </b-collapse>
        </div>
      </div>
    </div>
  </div>
</template>

<script>


  export default {
    props: ['content'],
    data() {
      return {
        isOpen: 0,
      }
    }
  }
</script>


