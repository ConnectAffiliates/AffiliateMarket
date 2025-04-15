<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { PageProps } from '@/types'

defineProps<{
  auth: PageProps['auth']
}>()
</script>

<template>
  <Head title="Publisher Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Publisher Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            Welcome to your Publisher Dashboard! Here you can:
            <ul class="list-disc list-inside mt-4">
              <li>Browse available campaigns</li>
              <li>Get your unique affiliate links</li>
              <li>Track your earnings</li>
              <li>View performance analytics</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template> 