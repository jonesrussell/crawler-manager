<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import MessageSection from '@/Components/MessageSection.vue';
import Tasks from '@/Components/Tasks.vue';
import {
  sendRequest,
  getLinks,
} from '@/crawlactions';

const props = defineProps({
  crawlsite: Object,
  tasks: Array,
  articles: Array,
});

const message = ref(null);

const handleSendRequest = async () => {
  message.value = await sendRequest(props.crawlsite);
};

const handleGetLinks = async () => {
  message.value = await getLinks(props.crawlsite);
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
                <div class="mt-4">
                  <button @click="handleSendRequest"
                    class="px-4 py-2 bg-blue-500 text-white rounded">Crawl Site</button>
                  <button @click="handleGetLinks"
                    class="px-4 py-2 bg-green-500 text-white rounded">Get Links</button>
                </div>

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
