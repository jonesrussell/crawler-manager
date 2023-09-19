<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";


const props = defineProps({
  crawlsite: Object,
  jobs: Array,
});

const dispatchJob = async (jobName) => {
  try {
    // Make a POST request to the dispatchJob route
    const route2 = route('crawlsites.dispatchJob', { crawlsite: props.crawlsite.id });
  
    console.log('route', route2);

    await router.post(route2, { jobName });
    console.log(`Dispatched job: ${jobName}`);
    // Optionally, you can show a success message or update the UI
  } catch (error) {
    console.error(`Failed to dispatch job: ${jobName}`, error);
    // Handle any errors or show an error message
  }
};
</script>

<!-- resources/js/Pages/Crawlsites/View.vue -->
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
                  <li v-for="job in jobs" :key="job.id">
                    <!-- Replace Link with button -->
                    <button @click="dispatchJob(job.name)" class="text-blue-600 underline">
                      {{ job.name }}
                    </button>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>
