<template>
    <nav class="p-4 bg-blue-600 text-white flex justify-between items-center">
        <div class="flex gap-4">
            <router-link
                :to="{ name: 'home' }"
                class="hover:underline text-lg font-semibold"
            >
                Главная
            </router-link>
            <router-link v-if="isAuthenticated"
                :to="{ name: 'knife' }"
                class="hover:underline text-lg"
            >
                Каталог ножей
            </router-link>
        </div>

        <div class="flex gap-4 items-center">
            <template v-if="isAuthenticated">
                <button
                    @click="logout"
                    class="px-4 py-2 bg-red-500 rounded hover:bg-red-600 transition"
                    style="cursor: pointer;"
                >
                    Выход
                </button>
            </template>
            <template v-else>
                <router-link
                    :to="{ name: 'register' }"
                    class="px-4 py-2 bg-green-500 rounded hover:bg-green-600 transition"
                >
                    Регистрация
                </router-link>
                <router-link
                    :to="{ name: 'login' }"
                    class="px-4 py-2 bg-gray-500 rounded hover:bg-gray-600 transition"
                >
                    Логин
                </router-link>
            </template>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Header",
    data() {
        return {
            isAuthenticated: !!localStorage.getItem("token"),
        };
    },
    methods: {
        updateAuthStatus(status) {
            this.isAuthenticated = status;
        },
        async logout() {
            try {
                const token = localStorage.getItem("token");
                if (!token) {
                    this.updateAuthStatus(false);
                    this.$router.push({ name: "login" });
                    return;
                }

                await this.$axios.delete("/auth/logout", {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                });

                localStorage.removeItem("token");
                localStorage.removeItem("user");
                this.updateAuthStatus(false);
                this.$router.push({ name: "login" });
            } catch (error) {
                console.error(
                    "Ошибка при выходе:",
                    error.response?.data || error
                );
            }
        },
    },
    created() {
        window.addEventListener("authChange", (event) => {
            this.updateAuthStatus(event.detail);
        });
    },
    beforeUnmount() {
        window.removeEventListener("authChange", this.updateAuthStatus);
    },
};
</script>
