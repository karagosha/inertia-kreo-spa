<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import Authenticated from "@/Layouts/Authenticated";
import {reactive, h} from "vue";
import Editor from "@tinymce/tinymce-vue";
import {Inertia} from "@inertiajs/inertia";

let submit = () => {
    if (props.form_type == "edit") {
        Inertia.put('/admin/feedback/' + props.feedback.id, form)
    } else {
        Inertia.post('/admin/feedback', form);
    }

};
const props = defineProps({
    errors: Object,
    form_type: String,
    feedback: Object,
    components: {
        'editor': Editor,
    },
})

let form = reactive({
    client: props.feedback ? props.feedback.client : '',
    text: props.feedback ? props.feedback.text : '',
    is_public: props.feedback ? ((props.feedback.is_public == "1") ? true : 0) : 0,
});
</script>

<template>
    <Head v-if="form_type == 'create'" title="Создание отзыва"/>
    <Head v-else title="Редактирование отзыва"/>

    <Authenticated>
        <div class="mx-2">
            <div class="rounded-2xl bg-white">
                <h2 class="text-xl mt-2 p-4" v-if="form_type == 'create'">Создание отзыва</h2>
                <h2 class="text-xl mt-2 p-4" v-else>Редактирование отзыва</h2>
            </div>
            <div class="bg-white rounded-2xl mt-3 p-4">
                <form method="POST" @submit.prevent="submit">
                    <div class="grid grid-cols-2 gap-5">
                        <div class="mb-3 col-span-2">
                            <label for="feedback-title" class="theme-label">Клиент *</label>
                            <input type="text" id="feedback-title" v-model="form.client"
                                   class="w-full theme-input"/>
                            <small class="text-red-500" v-if="errors.client">{{ errors.client }}</small>
                        </div>
                        <div class="mb-3 col-span-2">
                            <label for="feedback-desc" class="theme-label">Текст отзыва</label>
                            <editor :init="{ menubar: false, height:400 }" v-model="form.text"/>
                            <small class="text-red-500" v-if="errors.text">{{ errors.text }}</small>
                        </div>
                        <div class="mb-3 col-span-2">
                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <input id="feedback-is-public" v-model="form.is_public" type="checkbox"
                                           class="h-4 w-4 theme-input">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="feedback-is-public"
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
