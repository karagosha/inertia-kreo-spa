<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import {reactive, computed} from "vue";
import Editor from "@tinymce/tinymce-vue";
import {Inertia} from "@inertiajs/inertia";

const pageLabel = computed(() => props.form_type === 'create' ? 'Создание вакансии' : 'Редактирование вакансии');
const isCreate = computed(() => props.form_type === 'create');

let submit = () => {
    if (isCreate.value) {
        Inertia.post('/admin/job', form);
    } else {
        Inertia.put('/admin/job/' + props.job.id, form)
    }

};
const props = defineProps({
    errors: Object,
    form_type: String,
    job: Object,
    components: {
        'editor': Editor,
    },
})

let form = reactive({
    title: props.job ? props.job.title : '',
    description: props.job ? props.job.description : '',
    salary: props.job ? props.job.salary : '',
    hh_link: props.job ? props.job.hh_link : '',
    is_public: props.job ? ((props.job.is_public == "1") ? true : 0) : 0,
});
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
                        <label for="job-title" class="theme-label">Название вакансии *</label>
                        <input type="text" id="job-title" v-model="form.title"
                               class="w-full theme-input" placeholder="Веб-разработка"/>
                        <small class="text-red-500" v-if="errors.title">{{ errors.title }}</small>
                    </div>
                    <div class="mb-3 col-span-1">
                        <label for="job-path" class="theme-label">Заработная
                            плата</label>
                        <input type="text" id="job-path" v-model="form.salary" class="w-full theme-input"/>
                        <small class="text-red-500" v-if="errors.salary">{{ errors.salary }}</small>
                    </div>
                    <div class="mb-3 col-span-2">
                        <label for="job-path" class="theme-label">Ссылка на hh (вакансию)</label>
                        <input type="text" id="job-path" v-model="form.hh_link" class="w-full theme-input"/>
                        <small class="text-red-500" v-if="errors.hh_link">{{ errors.hh_link }}</small>
                    </div>
                    <div class="mb-3 col-span-2">
                        <label for="job-desc" class="theme-label">Описание
                            вакансии</label>
                        <editor :init="{ menubar: false, height:400 }" v-model="form.description"/>
                        <small class="text-red-500" v-if="errors.description">{{ errors.description }}</small>
                    </div>
                    <div class="mb-3 col-span-2">
                        <div class="flex items-start">
                            <div class="flex h-5 items-center">
                                <input id="job-is-public" v-model="form.is_public" type="checkbox"
                                       class="h-4 w-4 theme-input">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="job-is-public" class="theme-label">Опубликовать</label>
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
