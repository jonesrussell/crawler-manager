<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm, ref } from '@inertiajs/vue3';

const props = defineProps({
  Crawlsite: {
    type: Object,
    default: () => ({}),
  },
});

const form = useForm({
  id: props.Crawlsite.id,
  title: props.Crawlsite.title,
  content: props.Crawlsite.content,
  searchTerms: props.Crawlsite.searchTerms,
});

const searchTerms = ref(props.Crawlsite.searchTerms || '');

const submit = () => {
  form.put(route('crawlsites.update', props.Crawlsite.id));
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
                                <!-- Editable Title -->
                                <div class="mb-4">
                                    <InputLabel for="title" value="Title" />
                                    <TextInput id="title" type="text"
                                        class="mt-1 block w-full" v-model="form.title"
                                        required autofocus />
                                    <!-- Display error message if needed -->
                                    <InputError class="mt-2" :message="form.errors.title" />

                                    <!-- Add Search Terms Input -->
                                    <div class="mb-4">
                                        <InputLabel for="searchTerms"
                                            value="Search Terms (comma-separated)" />
                                        <TextInput id="searchTerms" type="text"
                                            class="mt-1 block w-full"
                                            v-model="searchTerms.value" />
                                    </div>
                                </div>
                                {{ Crawlsite.url }}
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
    </AuthenticatedLayout>
</template>
