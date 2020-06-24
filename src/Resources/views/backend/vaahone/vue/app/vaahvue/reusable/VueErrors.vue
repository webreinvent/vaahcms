<template>


    <article class="message is-danger" v-if="list">
        <div class="message-body">
            <ul v-for="item in list">
                <li>{{ item }}</li>
            </ul>
        </div>
    </article>

</template>

<script>
    export default {
        props: ['list'],
    }
</script>
