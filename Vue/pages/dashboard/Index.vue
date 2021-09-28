<script src="./IndexJs.js"></script>
<template>

    <!--sections-->
    <div class="block">
        <h1 class="title">Dashboard</h1>


        <div class="columns is-multiline">

            <template v-for="list in root.assets.dashboard.success">

                <div v-for="(item,key) in list" class="column is-one-fifth" style="display: grid">

                    <div class="card" style="border-radius: 0.75rem"
                         :class="item.link?'is-clickable ':''"
                         @click="goToLink(item.link)">

                        <header v-if="item.icon"
                                class="card-header has-text-centered is-block">
                            <b-icon :icon="item.icon"
                                    size="is-large">
                            </b-icon>
                        </header>

                        <div class="card-content">


                            <div class="content has-text-centered">
                                <span v-if="item.image" class="image is-96x96 is-inline-flex">
                                    <img class="is-rounded" :src="item.image">
                                </span>
                                <span v-if="item.count" class="is-size-2 has-text-weight-bold">
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
    .is-vcentered {
        align-items: center;
    }
</style>

