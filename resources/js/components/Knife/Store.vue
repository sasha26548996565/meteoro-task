<template>
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold text-center mb-4">Добавить нож</h2>
        <form @submit.prevent="saveKnife" class="space-y-4">
            <div class="flex flex-col">
                <label class="text-gray-700 font-medium">Материал клинка</label>
                <input
                    v-model="knife.material"
                    type="text"
                    placeholder="Сталь, титан и т. д."
                    class="input-field"
                    required
                />
            </div>

            <div class="flex flex-col">
                <label class="text-gray-700 font-medium">Длина клинка</label>
                <input
                    v-model="knife.blade_length"
                    type="text"
                    placeholder="Введите длину"
                    class="input-field"
                    required
                />
            </div>

            <div class="flex flex-col">
                <label class="text-gray-700 font-medium"
                    >Материал рукояти</label
                >
                <input
                    v-model="knife.handle"
                    type="text"
                    placeholder="Дерево, пластик и т. д."
                    class="input-field"
                    required
                />
            </div>

            <button
                type="submit"
                :disabled="loading"
                style="cursor: pointer;"
                class="w-full py-2 rounded-lg transition font-semibold"
                :class="{
                    'bg-blue-500 hover:bg-blue-600 text-white': !loading,
                    'bg-gray-400 cursor-not-allowed': loading,
                }"
            >
                <span v-if="loading">Сохранение...</span>
                <span v-else>Сохранить</span>
            </button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            knife: {
                material: "",
                blade_length: "",
                handle: "",
            },
            loading: false,
        };
    },
    methods: {
        async saveKnife() {
            if (this.loading) return;
            this.loading = true;

            try {
                const token = localStorage.getItem("token");
                await this.$axios.post("/knife/store", this.knife, {
                    headers: { Authorization: `Bearer ${token}` },
                });

                this.knife = { material: "", blade_length: "", handle: "" };
                this.$router.push({ name: "knife" });
            } catch (error) {
                console.error("Ошибка сохранения ножа:", error);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
.input-field {
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 6px;
    outline: none;
    transition: border-color 0.3s;
}

.input-field:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
}
</style>
