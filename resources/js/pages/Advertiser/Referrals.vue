<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AdvertiserLayout from '@/layouts/AdvertiserLayout.vue'
import { PageProps } from '@/types'
import { ref } from 'vue'

defineProps<{
  auth: PageProps['auth'],
  errors: {}
}>()

const referralCodes = ref([
  { id: 1, code: 'SUMMER2023', campaign: 'Summer Fashion Sale', type: 'Standard', created_at: '2023-05-01', uses: 45, active: true },
  { id: 2, code: 'TECH15', campaign: 'New Smartphone Launch', type: 'Standard', created_at: '2023-04-15', uses: 78, active: true },
  { id: 3, code: 'FITNESS23', campaign: 'Home Fitness Equipment', type: 'QR Code', created_at: '2023-04-01', uses: 32, active: true },
  { id: 4, code: 'SCHOOL10', campaign: 'Back to School Sale', type: 'Standard', created_at: '2023-07-15', uses: 0, active: false }
])
</script>

<template>
  <Head title="Referral Codes" />

  <AdvertiserLayout>
    <template #header>
      <div class="px-4 sm:px-0">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Referral Codes
        </h2>
        <p class="mt-1 text-sm text-gray-600">Manage your affiliate referral codes</p>
      </div>
    </template>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
      <div class="p-6 flex justify-between items-center border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Active Referral Codes</h3>
        <button
          class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Generate New Code
        </button>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uses</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th scope="col" class="relative px-6 py-3">
                <span class="sr-only">Actions</span>
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="code in referralCodes" :key="code.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ code.code }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ code.campaign }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ code.type }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ code.created_at }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ code.uses }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full" 
                      :class="{
                        'bg-green-100 text-green-800': code.active,
                        'bg-gray-100 text-gray-800': !code.active
                      }">
                  {{ code.active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button class="text-indigo-600 hover:text-indigo-900 mr-3">View</button>
                <button v-if="code.active" class="text-red-600 hover:text-red-900">Deactivate</button>
                <button v-else class="text-green-600 hover:text-green-900">Activate</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdvertiserLayout>
</template> 