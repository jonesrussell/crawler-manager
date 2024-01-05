<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import axios from 'axios';

const message = ref(null);

const props = defineProps({
  crawlsite: Object,
});

let responseData = ref(null);

const sendRequest = async () => {
  const url = 'https://localhost:3000/v1/matchlinks';
  const data = {
    Url: 'https://www.jonesrussell42.xyz',
    SearchTerms: 'PRIVACY',
    CrawlSiteId: 'jr42',
    MaxDepth: 3
  };

  try {
    const response = await axios.post(url, data);
    const result = response.data;
    console.log(result);
    responseData.value = result;

    // Retrieve the ID from the response
    const id = result.task_id;

    if (id) {
      storeTaskId(id, props.crawlsite.id);
    } else {
      console.error('Task ID is missing');
    }

  } catch (error) {
    console.error('Error:', error);
  }
};

const storeTaskId = async (taskId, crawlsiteId) => {
  const url = '/store-task-id'; // replace with your actual endpoint
  const data = {
    task_id: taskId,
    crawlsite_id: crawlsiteId,
  };

  try {
    const response = await axios.post(url, data);
    const result = response.data;
    console.log(result);
  } catch (error) {
    console.error('Error:', error);
  }
};

</script>

<template>
  <div>

    <Head title="Crawlsite View" />
    <AuthenticatedLayout>
      <template #header>
        <h2 class="text-xl font-semibold leading-tight text-white">
          {{ crawlsite.title }}
        </h2>
      </template>

      <!-- Message Section -->
      <div v-if="message" class="mt-4 p-4 bg-green-100 rounded border border-green-400">
        <h3 class="text-lg font-semibold mb-2">Message:</h3>
        <p>{{ message }}</p>
      </div>

      <!-- Content Section -->
      <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
              <!-- Display Crawlsite Details -->
              <div class="mb-4">
                <h3 class="text-lg font-semibold mb-2">Content:</h3>
                <p><strong>ID:</strong> {{ crawlsite.id }}</p>
                <p><strong>URL:</strong> {{ crawlsite.url }}</p>
                <p><strong>Search Terms:</strong> {{ crawlsite.searchTerms }}</p>
              </div>

              <!-- Button Section -->
              <div class="mt-4">
                <button @click="sendRequest" class="px-4 py-2 bg-blue-500 text-white rounded">Send Request</button>
              </div>

              <!-- Response Section -->
              <div v-if="responseData" class="mt-4 p-4 bg-green-100 rounded border border-green-400">
                <h3 class="text-lg font-semibold mb-2">Response:</h3>
                <pre>{{ responseData }}</pre>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>