<template>
    <div class="min-h-screen bg-gray-100 text-gray-900">
        <Header />
        <div class="p-6">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import Header from './components/Shared/Header.vue';

export default {
    name: "App",
    components: {
        Header
    }
}
</script>
