<script setup lang="ts">
// Placeholder for Campaign Detail component
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';

// Define props if needed, e.g., campaign ID
// const props = defineProps({
//   campaignId: String
// });

</script>

<template>
  <AuthenticatedLayout>
    <div class="p-4 sm:p-6 lg:p-8">
      <h1 class="text-2xl font-semibold text-gray-900">Campaign Detail</h1>
      <p class="mt-2 text-sm text-gray-600">
        Details for the selected campaign will be displayed here.
        <!-- Add campaign-specific details based on props -->
      </p>
    </div>
  </AuthenticatedLayout>
</template> 