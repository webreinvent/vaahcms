<template>

  <div style="width: 100%;">

    <div class="container is-fullhd">
      <div class="columns">
        <div class="column is-12">
          <section class="docs section">

            <p class="title is-4 has-text-centered">
              <a :href="'#'+link" class="">#</a>
              <a :name="link"></a>
              {{name}}
            </p>

            <b-tabs position="is-centered" :animated="false">
              <b-tab-item label="Preview" style="padding: 10px 0px;">

                <slot></slot>

              </b-tab-item>

              <b-tab-item label="Code">

                <div class="docs code">


                  <div class="level" v-bind:class="{'has-bottom-border': file_path}">

                    <div class="level-left">

                      <div class="level-item">
                        <strong>{{file_path}}</strong>
                      </div>

                    </div>

                    <div class="level-right">

                       <div class="level-item">
                         <b-button type="is-text">
                          <b-icon size="is-small" icon="align-justify"></b-icon>
                          <vh-copy
                            :data="code"
                            :label="'copy'"
                            :confirm_dialog="'buefy'">

                          </vh-copy>
                        </b-button>
                       </div>

                    </div>

                  </div>

                  <pre v-highlightjs="code">
                    <code class="vue">
                    </code>
                  </pre>

                </div>

              </b-tab-item>

            </b-tabs>




          </section>
        </div>
      </div>
    </div>

  </div>





</template>

<script>
  let slugify = require('slugify');
  export default {
    props: ['name', 'code', 'file_path'],
    components:{
    },
    data(){

      let obj = {
        link: null,
      };

      return obj;

    },
    mounted () {
      this.link = slugify(this.name.toLowerCase());
    },
    methods:{

    }
  }
</script>

<style scoped>
  .tab-content{
    padding: 10px 0px;
  }
</style>
