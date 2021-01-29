<template>
  <div class="crm-page-layout has-background-light">

    <div class="container is-fullhd has-padding-right-20">
      <div>
        <div class="box-area is-flex-desktop justify-flex-start align-items-flex-start has-margin-top-10">
          <div class="box has-padding-15 has-margin-left-20 has-width-550">
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
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


