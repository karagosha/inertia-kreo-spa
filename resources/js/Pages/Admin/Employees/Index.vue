<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import Authenticated from "@/Layouts/Authenticated";
import {Inertia} from "@inertiajs/inertia";
import Input from "@/Components/Input";

const props = defineProps({
    employees: Object,
})

let delete_func = (employee_id) => {
    if (confirm("Do you really want to delete?")) {
        Inertia.delete('/admin/employees/' + employee_id)
    }
};

function update_weight(employee_id, weight) {
    Inertia.post('/admin/item/update-weight/', {
        'weight': weight,
        'type': 'employee',
        'id': employee_id,
        onSuccess: () => {},
    })
}
</script>

<template>
    <Head title="Список сотрудников"/>
    <Authenticated>
        <div class="mx-2">

            <div class="rounded-2xl bg-white">
                <h2 class="text-xl mt-2 p-4">Сотрудники</h2>
            </div>
            <div class="bg-white rounded-2xl mt-3 p-4">
                <div>
                    <Link :href="route('employees.create')" class="bg-indigo-500 theme-btn p-1">добавить
                        сотрудника
                    </Link>
                </div>
                <table class="w-full table-auto mt-3">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Вес</th>
                        <th>Управление</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in employees.data">
                        <td class="p-3">{{ item.name }}</td>
                        <td style="text-align: -webkit-center">
                            <input type="number" v-model="item.weight"
                                   @change="update_weight(item.id, $event.target.value)"
                                   class="w-1/6 theme-input"/>
                        </td>
                        <td>
                            <div class="text-center">
                                <Link :href="`/admin/employees/${item.id}/edit`"
                                      class="bg-blue-500 theme-btn"><i class="fa fa-pen"></i>
                                </Link>
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

    </Authenticated>
</template>
