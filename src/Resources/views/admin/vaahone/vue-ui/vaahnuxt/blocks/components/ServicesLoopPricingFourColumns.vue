<template>
  <div class="ServicesLoopPricingFourColumns">
    <div class="pricing1 spacer has-background-light">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-10 has-text-centered">
            <h2 class="title is-1">{{content.main_heading}}</h2>
            <p class="subtitle is-6">{{content.sub_text}}</p>
          </div>
        </div>
        <div class="columns m-t-40">
          <div v-if="content.prices" v-for="price in content.prices" class="column is-3 aos-init aos-animate" data-aos="fade-up" data-aos-duration="1200">
            <div class="card card-shadow">
              <div class="card-body p-40 font-14">
                <p class="badge badge-danger p-10">{{price.badge}}</p>
                <h5 class="title">{{price.title}}</h5>
                <h6 class="subtitle">{{price.subtitle}}</h6>
                <div class="pricing">
                  <sup>{{price.currency}}</sup>
                  <span class="monthly display-5">{{price.money}}</span>
                  <small v-if="price.money" class="monthly">/mo</small>
                  <small v-if="price.money" class="yearly">/yr</small>
                  <span class="db">{{price.paymentduration}}</span>
                </div>
                <ul v-if="price.list" v-for="item in price.list" class="list-inline ml-3 mb-0">
                  <li>{{item.items}}</li>
                </ul>
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


