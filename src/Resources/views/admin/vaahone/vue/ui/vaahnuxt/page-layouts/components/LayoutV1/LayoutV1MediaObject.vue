<template>
  <div class="LayoutV1">

  <!--    MAIN-SECTION STARTS-->

    <div class="main-section">
      <div class="container is-fluid">
        <div class="columns">
          <div class="column is-12">

            <div class="items">
              <div class="columns">
                <div class="column is-6">
                  <div class="columns is-flex-mobile">
                    <div class="column is-2 is-2-mobile">
                      <img src="https://via.placeholder.com/50x50">
                    </div>
                    <div class="column is-10">
                      <nuxt-link to="/">
                        inhouse/<b>Project-1</b>
                      </nuxt-link>
                      <span class="tag is-rounded">Developer</span>
                      <p>Repository for <nuxt-link to="/">https://www.google.com</nuxt-link></p>
                    </div>
                  </div>
                </div>
                <div class="column is-6">
                  <div class="columns">
                    <div class="column is-6">
                      <ul class="has-padding-left-50-mobile">
                        <li class="is-inline-block">
                          <b-tooltip label="Pipeline Passed"
                                     position="is-top">
                            <b-icon
                                    icon="check"
                                    size="is-small">
                            </b-icon>
                          </b-tooltip>
                        </li>
                        <li class="is-inline-block">
                          <b-tooltip label="Stars"
                                     position="is-top">
                            <b-icon
                                    icon="star"
                                    size="is-small">
                            </b-icon>0
                          </b-tooltip>
                        </li>
                        <li class="is-inline-block">
                          <b-tooltip label="Forks"
                                     position="is-top">
                            <b-icon
                                    icon="source-fork"
                                    size="is-small">
                            </b-icon>10
                          </b-tooltip>
                        </li>
                        <li class="is-inline-block">
                          <b-tooltip label="Merge Requests"
                                     position="is-top">
                            <b-icon
                                    icon="source-merge"
                                    size="is-small">
                            </b-icon>10
                          </b-tooltip>
                        </li>
                        <li class="is-inline-block">
                          <b-tooltip label="Issues"
                                     position="is-top">
                            <b-icon
                                    icon="align-justify"
                                    size="is-small">
                            </b-icon>10
                          </b-tooltip>
                        </li>
                      </ul>
                    </div>
                    <div class="column is-6 is-hidden-mobile">
                      <p class="is-capitalized">updated feb 12, 2020</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>

          </div>
        </div>


      </div>
    </div>

  <!--    MAIN-SECTION ENDS-->

  </div>
</template>

<script>


  export default {
    props: ['content']
  }
</script>


