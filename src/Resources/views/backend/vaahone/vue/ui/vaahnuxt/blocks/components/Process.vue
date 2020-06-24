<template>

  <div class="spacer Process">

    <div class="container">
      <div class="columns is-centered ">
        <!-- Column -->
        <div class="column is-8 align-self-center has-text-centered" data-aos="fade-down" data-aos-duration="1200">
          <h1 class="title is-1">{{content.main_heading}}</h1>
          <h6 class="subtitle is-6">{{content.sub_text}}</h6> </div>
        <!-- Column -->
      </div>
      <div class="columns m-t-40">
        <div class="column is-12">
          <div>
            <div >
              <ul v-if="content.processes"
                  v-for="(process, index) in content.processes" class="timeline">
                <li v-if="index%2==0">
                  <div class="timeline-badge success"><img class="img-responsive" alt="user" :src="process.src"> </div>
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <h4 class="timeline-title title is-4">{{process.heading}}</h4>
                    </div>
                    <div class="timeline-body">
                      <p class="content">{{process.details}}</p>
                    </div>
                  </div>
                </li>
                <li v-else class="timeline-inverted">
                  <div class="timeline-badge warning"><img class="img-responsive" alt="user" :src="process.src""> </div>
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <h4 class="timeline-title title is-4">{{process.heading}}</h4>
                    </div>
                    <div class="timeline-body">
                      <p class="content">{{process.details}}</p>
                    </div>
                  </div>
                </li>
              </ul>
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
