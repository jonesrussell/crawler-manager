<template>
    <div v-if="message" class="mt-4 p-4 bg-green-100 rounded border border-green-400">
        <h3 class="text-lg font-semibold mb-2">Message:</h3>
        <pre>{{ message }}</pre>
    </div>
</template>
   
<script>
export default {
    props: ['message'],
}
</script>