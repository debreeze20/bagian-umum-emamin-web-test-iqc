<template>
    <router-view v-slot="{ Component, route }">
        <component :is="Component" :key="route.fullPath" />
    </router-view>
</template>

<script>
    export default {
        name: 'App',
    };

</script>
