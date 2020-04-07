<template>

    <article class="message is-success" v-if="list">
        <div class="message-body">
            <ul v-for="message in list">
                <li>{{ message }}</li>
            </ul>
        </div>
    </article>

</template>

<script>
    export default {
        props: ['list'],
    }
</script>
