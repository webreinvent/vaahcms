<template>
  <div class="docs">
    <div class="content">

      <a name="elementnine" />

      <!--section-heading-->
      <h3><a href="#elementtwo" class="title is-3">
        <span class="has-text-primary">#</span>
        FAQ</a>
      </h3>

      <b-collapse
        class="card has-margin-top-20"
        v-for="(collapse, index) of collapses"
        :key="index"
        :open="isOpen == index"
        @open="isOpen = index">
        <div
          slot="trigger"
          slot-scope="props"
          class="card-header"
          role="button">
          <div class="card-header-title">
            {{ collapse.title }}
          </div>
          <a class="card-header-icon">
            <b-icon
              :icon="props.open ? 'menu-down' : 'menu-up'">
            </b-icon>
          </a>
        </div>
        <div class="card-content">
          <div class="content">
            {{ collapse.text }}
          </div>
        </div>
      </b-collapse>

    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        isOpen: 0,
        collapses: [
          {
            title: 'How is AdonisJs different to Express or Koa?',
            text: 'Express and Koa are routing libraries with a thin layer of middleware on top. They are great for several use cases but fall apart when projects start to grow.\n' +
              '\n' +
              'Since your projects have their own standards and conventions, it may become harder to hire developers to work on them. As AdonisJs follows a set of standardized conventions, it should be easier to hire someone to work on existing AdonisJs apps.'
          },
          {
            title: 'Is AdonisJs for monolithic apps?',
            text: 'No. The AdonisJs Framework is a combination of multiple packages that gracefully integrate with the rest of your application.\n' +
              '\n' +
              'The framework provides a robust dependency injection layer leveraged by all official and 3rd party packages to offer functionality without manually wiring up each part of your app.'
          },
          {
            title: 'Are great for several use cases but fall apart when projects star?',
            text: 'Below is the list of frequently asked questions. If you think a common question is missing from the list, please create an issue here.'
          }
        ]
      }
    }
  }
</script>
