<script src="./IndexJs.js"></script>
<template>

    <!--sections-->
    <div class="block dashboard">
        <h1 class="title">Dashboard</h1>


        <div class="columns is-multiline">

            <template v-for="list in root.assets.dashboard.success">

                <div v-for="(item,key) in list" class="column is-3">

                    <div class="card" :class="item.link?'is-clickable':''"
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
                    </div>

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

