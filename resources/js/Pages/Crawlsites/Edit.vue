<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, useForm } from "@inertiajs/vue3";

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
});


const submit = () => {
    form.put(route("crawlsites.update", props.Crawlsite.id));
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
    </AuthenticatedLayout>
</template>

