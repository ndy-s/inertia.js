<template>
    <Head>
        <title>Home</title>
        <meta
            type="description"
            content="Home information"
            head-key="description"
        >
    </Head>
    <h1 class="text-3xl">Hello, {{ name }}. This is Home!</h1>

    <p>In this series, we will use following framework:</p>

    <ul>
        <li v-for="framework of frameworks" v-text="framework"></li>
    </ul>
</template>

<script setup>
    // import Layout from "@/Shared/Layout.vue";
    // import {defineComponent} from "vue";

    // export default {
    //     props: {
    //         name: String,
    //         frameworks: Array,
    //     },
    //
    //     components: {
    //         Layout,
    //     },
    // }

    // import {Head} from "@inertiajs/vue3";

    defineProps({
        name: String,
        frameworks: Array,
    });
</script>
<!--<script>-->
<!--    import Layout from "@/Shared/Layout.vue";-->

<!--    export default {-->
<!--        layout: Layout,-->
<!--    }-->
<!--</script>-->
