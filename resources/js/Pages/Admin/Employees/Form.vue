<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import {reactive, computed} from "vue";
import Editor from "@tinymce/tinymce-vue";
import {Inertia} from "@inertiajs/inertia";
import {} from "../../../../../public/vendor/laravel-filemanager/js/stand-alone-button"

let submit = () => {
    if (isCreate.value) {
        Inertia.post('/admin/employees', form);
    } else {
        Inertia.put('/admin/employees/' + props.employee.id, form)
    }
};
const props = defineProps({
    errors: Object,
    form_type: String,
    employee: Object,
    components: {
        'editor': Editor,
    },
});
const pageLabel = computed(() => props.form_type === 'create' ? 'Создание сотрудника' : 'Редактирование сотрудника');
const isCreate = computed(() => props.form_type === 'create');

let form;
if (!isCreate.value) {
    form = reactive({
        name: props.employee.name,
        job_position: props.employee.job_position,
        content: props.employee.content,
        image: props.employee.image,
        is_public: (props.employee.is_public == "1"),
    })
} else {
    form = reactive({
        name: null,
        job_position: null,
        content: null,
        image: null,
        is_public: false,
    });
}
</script>

<template>
    <Head :title="pageLabel"/>
    <div class="mx-2">
        <div class="rounded-2xl bg-white">
            <h2 class="text-xl mt-2 p-4">{{ pageLabel }}</h2>
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
</template>
<script>
$(document).ready(function () {
    $("#lfm").filemanager('image');
})
</script>
