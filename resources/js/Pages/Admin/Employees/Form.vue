<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import Authenticated from "@/Layouts/Authenticated";
import {reactive, h} from "vue";
import Editor from "@tinymce/tinymce-vue";
import {Inertia} from "@inertiajs/inertia";
import {} from "../../../../../public/vendor/laravel-filemanager/js/stand-alone-button"


let submit = () => {
    if (props.form_type == "edit") {
        Inertia.put('/admin/employees/' + props.employee.id, form)
    } else {
        Inertia.post('/admin/employees', form);
    }

};
const props = defineProps({
    errors: Object,
    form_type: String,
    employee: Object,
    components: {
        'editor': Editor,
    },
})

let form = reactive({
    name: props.employee ? props.employee.name : '',
    job_position: props.employee ? props.employee.job_position : '',
    content: props.employee ? props.employee.content : '',
    image: props.employee ? props.employee.image : '',
    is_public: props.employee ? ((props.employee.is_public == "1") ? true : 0) : 0,
});
</script>

<template>
    <Head v-if="form_type == 'create'" title="Создание сотрудника"/>
    <Head v-else title="Редактирование сотрудника"/>

    <Authenticated>
        <div class="mx-2">
            <div class="rounded-2xl bg-white">
                <h2 class="text-xl mt-2 p-4" v-if="form_type == 'create'">Создание сотрудника</h2>
                <h2 class="text-xl mt-2 p-4" v-else>Редактирование сотрудника</h2>
            </div>
            <div class="bg-white rounded-2xl mt-3 p-4">
                <form method="POST" @submit.prevent="submit">
                    <div class="grid grid-cols-2 gap-5">
                        <div class="mb-3 col-span-1">
                            <label for="employee-title" class="theme-label">ФИО *</label>
                            <input type="text" id="employee-title" v-model="form.name"
                                   class="w-full theme-input"/>
                            <small class="text-red-500" v-if="errors.name">{{ errors.name }}</small>
                        </div>
                        <div class="mb-3 col-span-1">
                            <label for="employee-path" class="theme-label">Должность</label>
                            <input type="text" id="employee-path" v-model="form.job_position"
                                   class="w-full theme-input"/>
                        </div>
                        <div class="mb-3 col-span-2">
                            <label for="employee-desc" class="theme-label">Описание сотрудника</label>
                            <editor :init="{ menubar: false, height:400 }" v-model="form.content"/>
                        </div>
                        <div class="mb-3 col-span-2">
                            <label class="theme-label">Фото</label>
                            <div class="input-group">
                                <div class="flex rounded-md shadow-sm">
                                    <span class="px-4 inline-flex items-center min-w-fit rounded-l-md
                                       text-sm bg-blue-500 text-white">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="cursor-pointer">
                                             <i class="fa fa-picture-o"></i> Choose
                                          </a>
                                    </span>
                                    <input id="thumbnail" type="text" v-model="form.image" name="filepath"
                                           class="w-full theme-input rounded-l-none">
                                </div>
                            </div>
                            <img id="holder" style="margin-top:15px;max-height:100px;">
                        </div>
                        <div class="mb-3 col-span-2">
                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <input id="employee-is-public" v-model="form.is_public" type="checkbox"
                                           class="h-4 w-4 theme-input">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="employee-is-public"
                                           class="theme-label">Опубликовать</label>
                                    <p class="text-gray-500">Get notified when someones posts a comment on a
                                        posting.</p>
                                </div>
                            </div>
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
<script>
$(document).ready(function () {
    $("#lfm").filemanager('image');
})
</script>
