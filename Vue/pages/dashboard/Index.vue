<script src="./IndexJs.js"></script>
<template>

    <!--sections-->
    <div v-if="assets" class="block dashboard">

        <section v-if="assets.dashboard && assets.dashboard.success" class="section is-paddingless">
            <div class="columns">
                <div class="column is-8">
                    <div class="columns is-multiline">
                        <div class="column is-12">
                            <div class="card">
                                <div v-if="assets.dashboard.success.vaahcms" class="card-content">
                                    <h2 class="title is-5">
                                        Welcome to Vaah<span class="has-text-weight-bold"
                                    >cms</span
                                    >
                                    </h2>
                                    <p class="subtitle is-6">
                                        We've assembled some links to get you started:
                                    </p>
                                    <div class="columns">
                                        <div class="column">
                                            <h4 class="title is-6">Get Started</h4>

                                            <b-button  type="is-primary"
                                                       @click="goToLink(root.current_url+'#/vaah/themes/')"
                                                      class="has-margin-bottom-5 has-padding-left-25
                                                             has-padding-right-25 has-padding-top-20
                                                             has-padding-bottom-20">
                                                <span v-if="assets.dashboard.success.vaahcms.has_activated_theme">
                                                    Go to Theme
                                                </span>
                                                <span v-else>
                                                    Activate Theme
                                                </span>
                                            </b-button>
                                            <p>or,<a href="https://docs.vaah.dev/vaahcms/theme/introduction.html">create your own theme</a></p>
                                        </div>
                                        <div class="column">
                                            <h4 class="title is-6">Next Steps</h4>
                                            <ul class="menu-item">

                                                <template v-for="module in assets.dashboard.success">

                                                    <template v-for="n_item in module.next_steps">
                                                        <li>
                                                            <a @click="goToLink(n_item.link)">
                                                                <b-icon
                                                                        :icon="n_item.icon"
                                                                        size="is-small">
                                                                </b-icon>
                                                                {{ n_item.name }}</a>
                                                        </li>
                                                    </template>

                                                </template>
                                            </ul>
                                        </div>
                                        <div class="column">
                                            <h4 class="title is-6">More Actions</h4>
                                            <ul class="menu-item">

                                                <template v-for="module in assets.dashboard.success">

                                                    <template v-for="n_item in module.actions">
                                                        <li>
                                                            <a @click="goToLink(n_item.link)">
                                                                <b-icon
                                                                        :icon="n_item.icon"
                                                                        size="is-small">
                                                                </b-icon>
                                                                {{ n_item.name }}</a>
                                                        </li>
                                                    </template>

                                                </template>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <template v-if="assets.dashboard.success"
                                  v-for="module in assets.dashboard.success">

                            <template v-if="module.card">

                                <div class="column is-12">
                                    <div class="columns">
                                        <div class="column">
                                            <h4 class="title is-5 has-margin-top-15">{{ module.card.title }}</h4>
                                        </div>
                                    </div>

                                    <div  class="columns">


                                        <div class="column is-9">
                                            <div
                                                    class="card is-flex has-border-right">


                                                <template v-if="(key+1)%4 !== 0"
                                                          v-for="(item,key) in module.card.list">
                                                    <div class="card is-shadowless has-icons-left">
                                                        <div class="card-content">
                                                            <div :class="'has-text-'+item.type">
                                                                <div :class="'has-background-'+item.type+'-light'"
                                                                     class="rounded-circle"
                                                                >

                                                                    <b-icon
                                                                            :icon="item.icon"
                                                                            size="is-small">
                                                                    </b-icon>
                                                                </div>
                                                                <p>{{ item.label }}</p>
                                                            </div>
                                                            <h5 class="title has-margin-top-5">{{ item.count }}</h5>
                                                            <a @click="goToLink(item.link)">View Details</a>
                                                        </div>
                                                    </div>
                                                    <div v-if="(key+1)%3 !== 0" class="hr"></div>
                                                </template>



                                                <!--<div class="card is-shadowless has-icons-left">
                                                    <div class="card-content">
                                                        <div class="has-text-danger">
                                                            <div
                                                                class="has-background-danger-light rounded-circle"
                                                            >

                                                                <b-icon
                                                                    icon="user"
                                                                    size="is-small">
                                                                </b-icon>
                                                            </div>
                                                            <p>Total Roles</p>
                                                        </div>
                                                        <h5 class="title has-margin-top-5">178</h5>
                                                        <a href="">View Details</a>
                                                    </div>
                                                </div>
                                                <div class="hr"></div>
                                                <div class="card is-shadowless has-icons-left">
                                                    <div class="card-content">
                                                        <div class="has-text-warning">
                                                            <div
                                                                class="has-background-warning-light rounded-circle"
                                                            >

                                                                <b-icon
                                                                    icon="user"
                                                                    size="is-small">
                                                                </b-icon>
                                                            </div>
                                                            <p>Total Permissions</p>
                                                        </div>
                                                        <h5 class="title has-margin-top-5">178</h5>
                                                        <a href="">View Details</a>
                                                    </div>
                                                </div>-->


                                            </div>
                                        </div>
                                        <div class="column">

                                            <template v-if="(key+1)%4 === 0"
                                                      v-for="(item,key) in module.card.list">
                                                <div class="card is-shadowless has-icons-left">
                                                    <div class="card-content">
                                                        <div :class="'has-text-'+item.type">
                                                            <div :class="'has-background-'+item.type+'-light'"
                                                                 class="rounded-circle"
                                                            >

                                                                <b-icon
                                                                        :icon="item.icon"
                                                                        size="is-small">
                                                                </b-icon>
                                                            </div>
                                                            <p>{{ item.label }}</p>
                                                        </div>
                                                        <h5 class="title has-margin-top-5">{{ item.count }}</h5>
                                                        <a @click="goToLink(item.link)">View Details</a>
                                                    </div>
                                                </div>
                                            </template>

                                           <!-- <div class="card  has-icons-left">
                                                <div class="card-content">
                                                    <div class="has-text-success">
                                                        <div
                                                                class="has-background-success-light rounded-circle"
                                                        >

                                                            <b-icon
                                                                    icon="user"
                                                                    size="is-small">
                                                            </b-icon>
                                                        </div>
                                                        <p class="has-text-success">Active Users</p>
                                                    </div>
                                                    <h5 class="title has-margin-top-5 has-text-success">178</h5>
                                                    <a href="">View Details</a>
                                                </div>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>


                            </template>
                        </template>


                    </div>
                </div>
                <div class="column is-4 sidebar-right">
                    <div class="card has-margin-left-10-desktop is-clipped">
                        <div class="block has-padding-15 is-bottom-marginless is-grouped  has-background-white-bis">
                            <template v-if="assets.dashboard.success"
                                      v-for="module in assets.dashboard.success">

                                <template v-if="module.expanded_header_links"
                                          v-for="(h_item,key) in module.expanded_header_links">
                                    <a @click="goToLink(h_item.link)" class="has-padding-right-15">
                                        <b-icon
                                                :icon="h_item.icon"
                                                size="is-small">
                                        </b-icon>
                                        {{ h_item.name }}
                                    </a>
                                </template>
                            </template>
                        </div>

                        <template v-if="assets.dashboard.success"
                                  v-for="module in assets.dashboard.success">

                            <template v-if="module.expanded_item">

                                <template v-for="item in module.expanded_item">
                                    <b-collapse
                                            class="card is-radiusless has-listing"
                                            animation="slide"
                                            aria-id="contentIdForA11y3">
                                        <template #trigger="props">
                                            <div
                                                    class="card-header"
                                                    role="button"
                                                    aria-controls="contentIdForA11y3">
                                                <p class="card-header-title">
                                                    {{ item.title }}
                                                </p>
                                                <a class="card-header-icon">
                                                    <b-icon
                                                            size="is-small"
                                                            :icon="props.open ? 'chevron-down' : 'chevron-up'">
                                                    </b-icon>
                                                </a>
                                            </div>
                                        </template>
                                    <!--    <div class="card-content">
                                            <div class="media">
                                                <div class="media-content">
                                                    <span class="tag is-link is-small">New</span>
                                                    <h6 class="is-inline title is-6">
                                                        <a href="#">View [fronted.partials.alerts] not found.</a>
                                                    </h6>

                                                    <p>
                                                        (Lorem ipsum dolor sit amet, consectetur adipisicing
                                                        elit. Animi atque consequatur
                                                    </p>
                                                    <small class="has-text-grey-light has-margin-top-5 is-block">
                                                        2021-12-24 01:15 / 5days ago
                                                    </small>
                                                </div>
                                            </div>
                                        </div>-->

                                        <template v-if="item.type === 'list'">
                                            <div v-if="l_index < item.list_limit"
                                                 v-for="(log,l_index) in item.list"
                                                 class="card-content">
                                                <div class="media">
                                                    <div class="media-content">
                                                        <h6 class="title is-6 has-margin-bottom-5">
                                                            <a @click="goToLink(item.link+'details/'+log.name)">{{ log.name }}</a>
                                                        </h6>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="card-footer">
                                                <div class="card-footer-item" >
                                                    <a @click="goToLink(item.link)">{{ item.link_text }}</a>
                                                </div>

                                            </div>
                                        </template>


                                        <template v-if="item.type === 'content'">

                                            <div class="card-content">
                                                <div class="content">
                                                   {{ item.description }}
                                                </div>
                                            </div>
                                            <footer class="card-footer">
                                                <template v-for="f_item in item.footer">
                                                    <a @click="goToLink(f_item.link)" class="card-footer-item">
                                                        <b-icon
                                                                :icon="f_item.icon"
                                                                size="is-small"
                                                                :class="'has-text-'+f_item.type">
                                                        </b-icon>
                                                       {{ f_item.name }}  {{ f_item.count }}
                                                    </a>
                                                </template>
                                            </footer>
                                           <!-- <div class="card-content">
                                                <div class="notification is-small is-info is-light">
                                                    Setup your SMTP details to send your emails <a>View Setting</a>
                                                </div>


                                            </div>-->
                                        </template>







                                    </b-collapse>
                                </template>

                            </template>

                        </template>





                    </div>
                </div>
            </div>
        </section>

    </div>
    <!--sections-->


</template>

<style>

    .dashboard .is-vcentered {
        align-items: center;
    }

    .dashboard .svg-inline--fa {
        width: auto !important;
    }

    .dashboard .icon.is-large {
        height: 7rem;
        width: 7rem;
        position: absolute;
        color: #d3d3d3a1;
        top: 22px;
        left: 93px;
    }


</style>

