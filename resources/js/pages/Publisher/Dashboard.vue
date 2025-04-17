<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'
import { PageProps } from '@/types'

defineProps<{
  errors: {}
  name: string
  quote: { message: string, author: string } 
}>()
</script>

<template>
  <Head title="Publisher Dashboard" />
  
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Publisher Dashboard</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
          <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Welcome!</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
              Welcome to your Publisher Dashboard! Here you can:
            </p>
          </div>
          <div class="border-t border-gray-200">
            <dl>
              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Browse Campaigns</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                  Find and join advertiser campaigns that match your audience.
                </dd>
              </div>
              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Track Performance</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                  Monitor your campaign performance metrics like clicks and conversions.
                </dd>
              </div>
              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Manage Links</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                  Get your unique tracking links and promotional materials.
                </dd>
              </div>
              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Track Earnings</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                  View your commission history and upcoming payments.
                </dd>
              </div>
            </dl>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template> 