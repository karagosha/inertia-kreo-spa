<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import {computed, reactive} from "vue";
import Editor from "@tinymce/tinymce-vue";
import {} from "../../../../../public/vendor/laravel-filemanager/js/stand-alone-button"
import {Inertia} from "@inertiajs/inertia";
import CodeMirror from "@/Components/CodeMirror";

const pageLabel = computed(() => props.form_type === 'create' ? 'Создание проекта' : 'Редактирование проекта');
const isCreate = computed(() => props.form_type === 'create');

let submit = () => {
    if (isCreate.value) {
        Inertia.post('/admin/projects', form);
    } else {
        Inertia.put('/admin/projects/' + props.project.id, form)
    }
};

const props = defineProps({
    errors: Object,
    form_type: String,
    project: Object,
    components: {
        'editor': Editor,
    },
})

let form = reactive({
    title: props.project ? props.project.title : null,
    desc: props.project ? props.project.content : null,
    slug: props.project ? props.project.slug : null,
    html_block: props.project ? props.project.html_block : null,
    weight: props.project ? props.project.weight : null,
    image: null,
    is_public: props.project ? (props.project.is_public == "1") : false,
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
                            <label for="project-title" class="theme-label">Название *</label>
                            <input type="text" id="project-title" v-model="form.title"
                                   class="w-full theme-input" placeholder="Расписание ТГУ"/>
                            <small class="text-red-500" v-if="errors.title">{{ errors.title }}</small>
                        </div>
                        <div class="mb-3 col-span-1" v-if="form_type == 'edit'">
                            <label for="project-path" class="theme-label">Путь</label>
                            <input type="text" id="project-path" v-model="form.slug" disabled
                                   class="w-full theme-input"/>
                        </div>
                        <div class="col-span-2 mb-3">
                            <label class="theme-label">Код отдельной страницы</label>
                            <CodeMirror v-model="form.html_block"></CodeMirror>
                        </div>
                        <div class="mb-3 col-span-2">
                            <label for="project-desc" class="theme-label">Описание проекта</label>
                            <editor :init="{     menubar: false    }" v-model="form.desc"/>
                            <small class="text-red-500" v-if="errors.desc">{{ errors.desc }}</small>
                        </div>
                        <div class="col-span-2">
                            <label for="project-desc" class="theme-label">Изображение проекта</label>
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
                            <small class="text-red-500" v-if="errors.image">{{ errors.image }}</small>
                            <img id="holder" style="margin-top:15px;max-height:100px;">
                        </div>
                        <div class="mb-3 col-span-2">
                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <input id="project-is-public" v-model="form.is_public" type="checkbox"
                                           class="h-4 w-4 theme-input">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="project-is-public"
                                           class="theme-label">Опубликовать</label>
                                    <p class="text-gray-500">Get notified when someones posts a comment on a
                                        posting.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="bg-indigo-500 text-white rounded-lg p-1">Сохранить</button>
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
