<template>
    <div class="max-w-md mx-auto p-6 bg-white shadow-md rounded">
        <h2 class="text-2xl font-bold mb-4">Регистрация</h2>
        <form @submit.prevent="register">
            <input
                v-model="form.name"
                type="text"
                placeholder="Имя"
                class="w-full p-2 border rounded mb-2"
            />
            <input
                v-model="form.email"
                type="email"
                placeholder="Email"
                class="w-full p-2 border rounded mb-2"
            />
            <input
                v-model="form.password"
                type="password"
                placeholder="Пароль"
                class="w-full p-2 border rounded mb-2"
            />
            <input
                v-model="form.password_confirmation"
                type="password"
                placeholder="Повторите пароль"
                class="w-full p-2 border rounded mb-4"
            />
            <button
                type="submit"
                style="cursor: pointer;"
                class="w-full bg-blue-500 text-white py-2 rounded flex justify-center items-center"
            >
                <span
                    v-if="loading"
                    class="animate-spin border-2 border-white border-t-transparent rounded-full w-5 h-5"
                ></span>
                <span v-else>Зарегистрироваться</span>
            </button>
        </form>
        <p v-if="error" class="text-red-500 mt-2">{{ error }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
            },
            error: null,
            loading: false,
        };
    },
    methods: {
        async register() {
            this.loading = true;
            this.error = null;

            try {
                let response = await this.$axios.post(
                    "/auth/register",
                    this.form
                );

                localStorage.setItem("token", response.data.token);
                localStorage.setItem(
                    "user",
                    JSON.stringify(response.data.user)
                );

                window.dispatchEvent(
                    new CustomEvent("authChange", { detail: true })
                );
                this.$router.push({ name: "home" });
            } catch (err) {
                this.error =
                    err.response?.data?.message || "Ошибка регистрации";
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
