<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import axios from 'axios';
import MessageSection from "@/Components/MessageSection.vue";
import Tasks from '@/Components/Tasks.vue'

const message = ref(null);

const props = defineProps({
  crawlsite: Object,
  tasks: Array,
  articles: Array,
});

const sendRequest = async () => {
  const url = 'https://localhost:3000/v1/matchlinks';
  const data = {
    Url: props.crawlsite.url,
    SearchTerms: props.crawlsite.searchTerms,
    CrawlSiteId: props.crawlsite.id,
    MaxDepth: 3
  };

  try {
    const response = await axios.post(url, data);
    const result = response.data;
    console.log(result);
    message.value = JSON.stringify(result, null, 2);

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
  const url = '/store-task-id';
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

const getLinks = async () => {
  const url = `https://localhost:3000/v1/getlinks?crawlsiteid=${props.crawlsite.id}`;

  try {
    const response = await axios.get(url);
    const result = response.data;
    console.log(result);
    message.value = JSON.stringify(result, null, 2);

    // Save the links to the database
    for (let link of result.links) {
      const article = {
        url: link.url,
        crawlsite_id: props.crawlsite.id,
      };

      console.log('article', article);

      try {
        const response = await axios.post('/store-article', article);
        const result = response.data;
        console.log(result);
      } catch (error) {
        console.error('Error:', error);
      }
    }
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

      <MessageSection :message="message" />

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
                <button @click="sendRequest" class="px-4 py-2 bg-blue-500 text-white rounded">Crawl Site</button>
                <button @click="getLinks" class="px-4 py-2 bg-green-500 text-white rounded">Get Links</button>
              </div>

              <!-- Tasks Section -->
              <Tasks :tasks="tasks" />

              <!-- Articles Section -->
              <div class="mt-4">
                <h3 class="text-lg font-semibold mb-2">Articles:</h3>
                <ul>
                  <li v-for="article in articles" :key="article.id">
                    <a :href="article.url" target="_blank">{{ article.url }}</a>
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