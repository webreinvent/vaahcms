<script src="./IndexJs.js"></script>
<template>

    <!--sections-->
    <div class="block dashboard">
        <h1 class="title">Dashboard</h1>


        <div class="columns is-multiline">

            <template v-for="list in root.assets.dashboard.success">

                <div v-for="(item,key) in list" class="column"
                     :class="item.column?item.column:'is-3'" style="display: grid">

                    <div class="card"
                         :class="item.link?'is-clickable '+item.card_classes:''"
                         @click="goToLink(item.link)">

                        <!--<header v-if="item.icon"
                                class="card-header has-text-centered is-block">
                            <b-icon :icon="item.icon"
                                    size="is-large">
                            </b-icon>
                        </header>-->

                        <div class="card-content">


                            <div class="content has-text-centered">

                                <b-icon v-if="item.icon"
                                        :icon="item.icon"
                                        size="is-large">
                                </b-icon>

                                <span v-if="item.image" class="image is-96x96 is-inline-flex">
                                    <img class="is-rounded" :src="item.image">
                                </span>
                                <span v-if="item.count"
                                      style="font-size: 4.5rem;font-weight: 500;position: relative">
                                   {{item.count}}
                                </span>
                                <hr v-if="item.label"  />
                                <span v-if="item.label" class="has-text-weight-bold">
                                   {{item.label}}
                                </span>
                            </div>
                        </div>
                    </div>

                   <!-- <div class="card" :class="item.card_classes">
                        <header class="card-header">
                            <p class="card-header-title has-text-centered is-block">
                                {{ $vaah.toLabel(key).toUpperCase()}}
                            </p>
                        </header>

                        <div class="card-content">

                            <div class="content is-size-1 has-text-centered has-text-weight-bold">
                                {{ typeof item.count !== 'boolean'?item.count:' '}}
                            </div>
                        </div>
                    </div>-->

                   <!-- <div class="card" :class="item.link?'is-clickable':''"
                         @click="goToLink(item.link)">
                        <div class="card-content" :class="item.card_classes">
                            <div class="media is-vcentered">
                                <div class="media-left" :class="item.text_classes">
                                    <b-icon
                                            :icon="item.icon"
                                            size="is-large">
                                    </b-icon>
                                </div>
                                <div class="media-content has-text-centered">
                                    <p class="title is-4"
                                       :class="item.text_classes">
                                        {{ typeof item.count !== 'boolean'?item.count:' '}}
                                    </p>
                                    <p class="subtitle is-6" :class="item.text_classes">
                                        {{ $vaah.toLabel(key).toUpperCase()}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>-->

                </div>

            </template>


        </div>

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

