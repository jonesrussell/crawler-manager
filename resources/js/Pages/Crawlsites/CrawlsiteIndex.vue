<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    crawlsites: {
        type: Object,
        default: () => ({}),
    },
});
const form = useForm({});

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("crawlsites.destroy", id));
    }
}
</script>

<template>
    <Head title="crawlsites" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                crawlsites Index
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-2">
                            <Link :href="route('crawlsites.create')">
                            <PrimaryButton>Add Crawlsite</PrimaryButton>
                            </Link>
                        </div>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Title</th>
                                        <th scope="col" class="px-6 py-3">URL</th>
                                        <!-- Add this th for the Search Terms -->
                                        <th scope="col" class="px-6 py-3">Search Terms</th>
                                        <th scope="col" class="px-6 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="Crawlsite in crawlsites" :key="Crawlsite.id"
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4">
                                            <Link :href="route('crawlsites.show', Crawlsite.id)">
                                            {{ Crawlsite.title }}
                                            </Link>
                                        </td>
                                        <td class="px-6 py-4 hide-url">
                                            {{ Crawlsite.url }}
                                        </td>
                                        <!-- Add this td for the Search Terms -->
                                        <td class="px-6 py-4">{{ Crawlsite.searchTerms }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-2">
                                                <Link :href="route('crawlsites.edit', Crawlsite.id)"
                                                    class="px-4 py-2 text-white bg-blue-600 rounded-lg">Edit</Link>
                                                <PrimaryButton class="bg-red-700" @click="destroy(Crawlsite.id)">
                                                    Delete
                                                </PrimaryButton>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
