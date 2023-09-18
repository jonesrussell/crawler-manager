<!-- resources/js/Pages/Crawlsites/View.vue -->
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { defineProps } from 'vue';

const props = defineProps({
  crawlsite: Object,
  jobs: Array, // Add the jobs prop here
});
</script>

<template>
    <div>
      <Head title="Crawlsite View" />
  
      <AuthenticatedLayout>
        <template #header>
          <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ crawlsite.title }}
          </h2>
        </template>
  
        <div class="py-12">
          <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                <!-- Display Crawlsite Details -->
                <div>
                  <p>ID: {{ crawlsite.id }}</p>
                  <p>URL: {{ crawlsite.url }}</p>
                  <!-- Add more details as needed -->

                  <!-- Display List of Jobs -->
                  <h3 class="text-lg font-semibold mt-4">Jobs:</h3>
                  <ul>
                    <li v-for="job in jobs" :key="job.id">{{ job.name }}</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </AuthenticatedLayout>
    </div>
</template>
