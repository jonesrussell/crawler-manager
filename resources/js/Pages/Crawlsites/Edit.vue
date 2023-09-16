<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, computed } from 'vue';

const props = defineProps({
    Crawlsite: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    id: props.Crawlsite.id,
    url: props.Crawlsite.url,
    content: props.Crawlsite.content,
    tags: [],
});


const submit = () => {
    form.put(route("crawlsites.update", props.Crawlsite.id));
};


const newTag = ref('');
const tagOptions = computed(() => []);
const addTag = () => {
    if (newTag.value.trim() === '') {
        return;
    }

    if (!form.tags.includes(newTag.value)) {
        form.tags.push(newTag.value);
    }

    newTag.value = '';
};

const removeTag = (tag) => {
    form.tags = form.tags.filter((t) => t !== tag);
};
</script>

<template>
    <Head title="Crawlsite Edit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Crawlsite Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="url" value="URL" />

                                <TextInput id="url" type="text" class="mt-1 block w-full" v-model="form.url" required
                                    autofocus autocomplete="username" />

                                <InputError class="mt-2" :message="form.errors.url" />
                            </div>
                            <PrimaryButton type="submit" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Submit
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <InputLabel for="tags" value="Tags" />
            <div class="flex space-x-2 mt-1">
                <!-- Input for adding new tags -->
                <TextInput id="tags" type="text" class="block w-full" v-model="newTag" placeholder="Add tags..." />
                <PrimaryButton @click="addTag">Add</PrimaryButton>
            </div>
            <div class="mt-2">
                <!-- Display existing tags -->
                <span v-for="(tag, index) in form.tags" :key="index"
                    class="bg-gray-200 px-2 py-1 rounded-full text-sm text-gray-700 mr-2">
                    {{ tag }}
                    <button class="ml-1" @click="removeTag(tag)" type="button">
                        Remove
                    </button>
                </span>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

