<template>
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Список ножей</h2>
            <router-link
                :to="{ name: 'knifeStore' }"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
            >
                Добавить нож
            </router-link>
        </div>

        <div v-if="loading" class="text-gray-500">Загрузка...</div>
        <div v-else-if="knives.length === 0" class="text-gray-500">
            Ножей пока нет.
        </div>
        <ul v-else class="space-y-2">
            <li
                v-for="knife in knives"
                :key="knife.id"
                class="border p-3 rounded-lg shadow-sm bg-gray-50"
            >
                <strong>{{ knife.material }}</strong> –
                <span>{{ knife.blade_length }} см</span> –
                <span>{{ knife.handle }}</span>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "Index",
    data() {
        return {
            knives: [],
            loading: true,
        };
    },
    async mounted() {
        await this.fetchKnives();
    },
    methods: {
        async fetchKnives() {
            try {
                const token = localStorage.getItem("token");
                const response = await this.$axios.get("/knife", {
                    headers: { Authorization: `Bearer ${token}` },
                });
                this.knives = response.data.knives;
            } catch (error) {
                console.error("Ошибка загрузки ножей:", error);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
