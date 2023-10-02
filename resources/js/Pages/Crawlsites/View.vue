<script setup>
import { ref, onMounted } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";

const message = ref(null);
const broadcastData = ref(null);

const props = defineProps({
  crawlsite: Object,
  jobs: Array,
});

const dispatchJob = async (jobName) => {
  try {
    const route2 = route('crawlsites.dispatchJob', { crawlsite: props.crawlsite.id });
    await router.post(route2, { jobName });
    console.log(`Dispatched job: ${jobName}`);
  } catch (error) {
    console.error(`Failed to dispatch job: ${jobName}`, error);
  }
};

// Listen for the broadcast and update broadcastData
window.Echo.private('crawler-job-output')
  .listen('CrawlerJobOutputEvent', (e) => {
    console.log('Received broadcast data:', e.output);
    broadcastData.value = e.output;
    // Handle the broadcast data here
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

      <!-- Message Section -->
      <div v-if="message" class="mt-4 p-4 bg-green-100 rounded border border-green-400">
        <h3 class="text-lg font-semibold mb-2">Message:</h3>
        <p>{{ message }}</p>
      </div>

      <!-- Content and Broadcasted Output Sections -->
      <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
              <!-- Display Crawlsite Details -->
              <div>
                <h3 class="text-lg font-semibold mb-4">Content:</h3>
                <p>ID: {{ crawlsite.id }}</p>
                <p>URL: {{ crawlsite.url }}</p>
                <p>Search Terms: {{ crawlsite.searchTerms }}</p>
                
                <!-- Display List of Jobs -->
                <h4 class="text-base font-semibold mt-4">Jobs:</h4>
                <ul>
                  <li v-for="job in jobs" :key="job.id">
                    <button @click="dispatchJob(job.name)" class="text-blue-600 underline">
                      {{ job.name }}
                    </button>
                  </li>
                </ul>
              </div>
            </div>

            <!-- Broadcasted Output Section -->
            <div class="p-6 bg-white border-b border-gray-200 mt-4">
              <h3 class="text-lg font-semibold mb-2">Broadcasted Output:</h3>
              <pre v-if="broadcastData">{{ broadcastData }}</pre>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>

