<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import Authenticated from "@/Layouts/Authenticated";
import {Inertia} from "@inertiajs/inertia";
import Input from "@/Components/Input";

const props = defineProps({
    feedback: Object,
})

let delete_func = (feedback_id) => {
    if (confirm("Do you really want to delete?")) {
        Inertia.delete('/admin/feedback/' + feedback_id)
    }
};

function update_weight(feedback_id, weight) {
    Inertia.post('/admin/item/update-weight/', {
        'weight': weight,
        'type': 'feedback',
        'id': feedback_id,
        onSuccess: () => {},
    })
}
</script>

<template>
    <Head title="Список отзывов"/>
    <Authenticated>
        <div class="mx-2">

            <div class="rounded-2xl bg-white">
                <h2 class="text-xl mt-2 p-4">Отзывы</h2>
            </div>
            <div class="bg-white rounded-2xl mt-3 p-4">
                <div>
                    <Link :href="route('feedback.create')" class="bg-indigo-500 theme-btn p-1">добавить
                        отзыв
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
                    <tr v-for="item in feedback.data">
                        <td class="p-3">{{ item.client }}</td>
                        <td style="text-align: -webkit-center">
                            <input type="number" v-model="item.weight"
                                   @change="update_weight(item.id, $event.target.value)"
                                   class="w-1/6 theme-input"/>
                        </td>
                        <td>
                            <div class="text-center">
                                <Link :href="`/admin/feedback/${item.id}/edit`"
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


<style scoped>

</style>
