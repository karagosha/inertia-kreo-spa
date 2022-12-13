<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import Authenticated from "@/Layouts/Authenticated";
import {reactive, h} from "vue";
import {Inertia} from "@inertiajs/inertia";

let submit = () => {
    if (props.form_type == "edit") {
        Inertia.put('/admin/users/' + props.user.id, form)
    } else {
        Inertia.post('/admin/users', form);
    }

};
const props = defineProps({
    errors: Object,
    form_type: String,
    user: Object,
    gen_pass: String,
})

let form = reactive({
    name: props.user ? props.user.name : '',
    email: props.user ? props.user.email : '',
    password: props.gen_pass ? props.gen_pass : '',
    role_slug: '',
});
</script>

<template>
    <Head v-if="form_type == 'create'" title="Создание пользователя"/>

    <Authenticated>
        <div class="mx-2">
            <div class="rounded-2xl bg-white">
                <h2 class="text-xl mt-2 p-4" v-if="form_type == 'create'">Создание пользователя</h2>
            </div>
            <div class="bg-white rounded-2xl mt-3 p-4">
                <form method="POST" @submit.prevent="submit">
                    <div class="grid grid-cols-2 gap-5">
                        <div class="mb-3 col-span-1">
                            <label for="user-name" class="theme-label">ФИО *</label>
                            <input type="text" id="user-name" v-model="form.name" class="w-full theme-input"/>
                            <small class="text-red-500" v-if="errors.name">{{ errors.name }}</small>
                        </div>
                        <div class="mb-3 col-span-1">
                            <label for="user-email" class="theme-label">Почта *</label>
                            <input type="email" id="user-email" v-model="form.email"
                                   class="w-full theme-input"/>
                            <small class="text-red-500" v-if="errors.email">{{ errors.email }}</small>
                        </div>
                        <div class="mb-3 col-span-1">
                            <label for="user-password" class="theme-label">Пароль *</label>
                            <input type="password" id="user-password" v-model="form.password"
                                   class="w-full theme-input"/>
                            <small>Не забудьте записать себе пароль: {{ form.password }} </small>
                            <small class="text-red-500" v-if="errors.password">{{ errors.password }}</small>
                        </div>
                        <div class="mb-3 col-span-1">
                            <label for="user-path" class="theme-label" >Роль пользователя</label>
                            <select class="theme-input w-full" v-model="form.role_slug">
                                <option value="">Пользователь</option>
                                <option value="admin">Админ</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="bg-indigo-500 theme-btn">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </Authenticated>

</template>
<style>

</style>
