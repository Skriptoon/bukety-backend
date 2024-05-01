<template>
    <div class="card">
        <div
            class="flex align-content-center h-screen flex-wrap card-container blue-container">

            <Block class="mx-auto w-30rem">
                <Head title="Log in"/>

                <div
                    v-if="status"
                    class="mb-4 font-medium text-sm text-green-600"
                >
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <div class="mt-5">
                        <sp-input
                            v-model="form"
                            name="email"
                            label="E-mail"
                        />
                    </div>

                    <div class="mt-5">
                        <sp-password
                            v-model="form"
                            name="password"
                            label="Пароль"
                        />
                    </div>

                    <div class="mt-5 flex align-items-center">
                        <checkbox
                            v-model="form.remember"
                            name="remember"
                            input-id="remember"
                            :binary="true"
                        />
                        <label for="remember" class="ml-2">Запомнить</label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <!--                <Link-->
                        <!--                    v-if="canResetPassword"-->
                        <!--                    :href="route('password.request')"-->
                        <!--                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"-->
                        <!--                >-->
                        <!--                    Forgot your password?-->
                        <!--                </Link>-->

                        <Button type="submit" :disabled="form.processing">
                            Войти
                        </Button>
                    </div>
                </form>
            </Block>
        </div>
    </div>
</template>

<script>
import {Head, useForm} from '@inertiajs/vue3';
import SpPassword from '@/Components/Form/SpPassword.vue';
import SpInput from '@/Components/Form/SpInput.vue';
import Button from 'primevue/button';
import Block from '@/Components/Block.vue';
import Checkbox from 'primevue/checkbox';

export default {
    name: 'login',

    components: {
        SpInput,
        SpPassword,
        Button,
        Checkbox,
        Block,
        Head,
    },

    props: {
        canResetPassword: Boolean,
        status: String,
    },

    data() {
        return {
            form: useForm({
                email: null,
                password: null,
                remember: false,
            }),
        };
    },

    methods: {
        submit() {
            this.form.post(route('login'), {
                onFinish: () => this.form.reset('password'),
            });
        },
    },
};
</script>
