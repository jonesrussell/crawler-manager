<template>
  <div v-if="tasks && tasks.length > 0" class="mt-4 p-4 bg-green-100 rounded border border-green-400">
    <h3 class="text-lg font-semibold mb-2">Tasks:</h3>
    <table class="table-auto w-full">
      <thead>
        <tr>
          <th class="px-4 py-2">Task ID</th>
          <th class="px-4 py-2">User ID</th>
          <!-- Add more columns as needed -->
        </tr>
      </thead>
      <tbody>
        <tr v-for="task in tasks" :key="task.id">
          <td class="border px-4 py-2">{{ task.id }}</td>
          <td class="border px-4 py-2">{{ task.user_id }}</td>
          <!-- Render more columns as needed -->
        </tr>
      </tbody>
    </table>
  </div>
  <div v-else class="mt-4 p-4 bg-red-100 rounded border border-red-400">
    <h3 class="text-lg font-semibold mb-2">No Tasks Available</h3>
    <p>There are currently no tasks available.</p>
  </div>
</template>
   
<script>
export default {
  props: ['tasks'],
}
</script>