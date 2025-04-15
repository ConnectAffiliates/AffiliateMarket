<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { PageProps } from '@/types'

defineProps<{
  auth: PageProps['auth']
}>()
</script>

<template>
  <Head title="Advertiser Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Advertiser Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            Welcome to your Advertiser Dashboard! Here you can:
            <ul class="list-disc list-inside mt-4">
              <li>Create and manage advertising campaigns</li>
              <li>Generate tracking links</li>
              <li>Monitor campaign performance</li>
              <li>Manage your affiliate network</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template> 