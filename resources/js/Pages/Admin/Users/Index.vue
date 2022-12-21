<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import Authenticated from "@/Layouts/AdminNav";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    users: Object,
    roles: Object,
})

let delete_func = (user_id) => {
    if (confirm("Do you really want to delete?")) {
        Inertia.delete('/admin/users/' + user_id)
    }
};

let change_role = (user_id) => {
    Inertia.put('/admin/users/' + user_id, {'role_slug': event.target.value})
}

</script>

<template>
    <Head title="Список пользователей"/>
        <div class="mx-2">
            <div class="rounded-2xl bg-white">
                <h2 class="text-xl mt-2 p-4">Пользователи</h2>
            </div>
            <div class="bg-white rounded-2xl mt-3 p-4">
                <div>
                    <Link :href="route('users.create')" class="bg-indigo-500 theme-btn p-1">добавить
                        пользователя
                    </Link>
                </div>
                <table class="w-full table-auto mt-3">
                    <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Почта</th>
                        <th>Управление</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in users.data" :key="item.id">
                        <td class="p-3">{{ item.name }}</td>
                        <td class="p-3">{{ item.email }}</td>
                        <td>
                            <div class="text-center flex gap-5">
                                <select @change="change_role(item.id)"
                                        class="block rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Пользователь</option>
                                    <option :selected="item.is_admin" value="admin">Админ</option>
                                </select>
                                <Link @click.prevent="delete_func(item.id)"
                                      class="bg-red-500 theme-btn"><i class="fa fa-trash"></i>
                                </Link>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
</template>

