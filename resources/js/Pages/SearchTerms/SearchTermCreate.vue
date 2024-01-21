<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
  term: '',
});

const submit = () => {
  form.post(route('terms.store'));
};
</script>

<template>
 <Head title="Search Term Create" />

 <AuthenticatedLayout>
   <template #header>
     <h2 class="text-xl font-semibold leading-tight text-gray-800">
       Search Term Create
     </h2>
   </template>

   <div class="py-12">
     <div class="mx-auto max-w-7xl">
       <div class="overflow-hidden bg-[#171923] shadow-sm sm:rounded-lg">
         <div class="p-6 bg-[#171923] border-b border-gray-200">
           <form @submit.prevent="submit">
             <div>
               <InputLabel for="term" value="Term" />

               <TextInput
                id="term"
                type="text"
                class="mt-1 block w-full"
                v-model="form.term"
                required
                autofocus
               />

               <InputError
                class="mt-2"
                :message="form.errors.term"
               />
             </div>

             <PrimaryButton
               type="submit"
               :class="{ 'opacity-25': form.processing }"
               :disabled="form.processing"
             >
               Submit
             </PrimaryButton>
           </form>
         </div>
       </div>
     </div>
   </div>
 </AuthenticatedLayout>
</template>
