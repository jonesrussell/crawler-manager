<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  searchTerms: {
    type: Array,
    default: () => ([]),
  },
});
const form = useForm({});

function destroy(id) {
  if (confirm('Are you sure you want to Delete')) {
    form.delete(route('terms.destroy', id));
  }
}
</script>

<template>
   <Head title="searchTerms" />

   <AuthenticatedLayout>
       <template #header>
           <h2 class="text-xl font-semibold leading-tight text-gray-800">
               Search Terms Index
           </h2>
       </template>

       <div class="py-12">
           <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
               <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                  <div class="p-6 bg-white border-b border-gray-200">
                      <div class="mb-2">
                          <Link :href="route('terms.create')">
                          <PrimaryButton>Add Search Term</PrimaryButton>
                          </Link>
                      </div>
                      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                              <thead
                                 class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                 <tr>
                                     <th scope="col" class="px-6 py-3">Term</th>
                                     <th scope="col" class="px-6 py-3">Actions</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr v-for="searchTerm in searchTerms" :key="searchTerm.id"
                                     class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                     <td class="px-6 py-4">
                                         <Link :href="route('terms.show', searchTerm.id)">
                                         {{ searchTerm.term }}
                                         </Link>
                                     </td>
                                     <td class="px-6 py-4">
                                         <div class="flex space-x-2">
                                             <Link :href="route('terms.edit', searchTerm.id)"
                                                class="px-4 py-2 text-white bg-blue-600 rounded-lg">Edit</Link>
                                             <PrimaryButton class="bg-red-700" @click="destroy(searchTerm.id)">
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
