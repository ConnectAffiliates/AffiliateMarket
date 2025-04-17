<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AdvertiserLayout from '@/layouts/AdvertiserLayout.vue'
import { PageProps } from '@/types'
import { ref } from 'vue'

defineProps<{
  auth: PageProps['auth'],
  errors: {}
}>()

const campaigns = ref([
  { 
    id: 1, 
    name: 'Summer Fashion Sale', 
    status: 'active', 
    budget: 'TZS 2,500,000',
    created_at: '2023-05-01',
    end_date: '2023-08-31'
  },
  { 
    id: 2, 
    name: 'New Smartphone Launch', 
    status: 'active', 
    budget: 'TZS 5,000,000',
    created_at: '2023-04-15',
    end_date: '2023-07-15'
  },
  { 
    id: 3, 
    name: 'Home Fitness Equipment', 
    status: 'active', 
    budget: 'TZS 1,800,000',
    created_at: '2023-04-01',
    end_date: '2023-06-30'
  },
  { 
    id: 4, 
    name: 'Back to School Sale', 
    status: 'paused', 
    budget: 'TZS 1,200,000',
    created_at: '2023-07-15',
    end_date: '2023-08-31'
  }
])
</script>

<template>
  <Head title="Campaigns" />

  <AdvertiserLayout>
    <template #header>
      <div class="px-4 sm:px-0">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Campaigns
        </h2>
        <p class="mt-1 text-sm text-gray-600">Manage your marketing campaigns</p>
      </div>
    </template>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
      <div class="p-6 flex justify-between items-center border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Your Campaigns</h3>
        <Link
          :href="route('advertiser.campaigns.create')"
          class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Create Campaign
        </Link>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Budget</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
              <th scope="col" class="relative px-6 py-3">
                <span class="sr-only">Actions</span>
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="campaign in campaigns" :key="campaign.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ campaign.name }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full" 
                      :class="{
                        'bg-green-100 text-green-800': campaign.status === 'active',
                        'bg-yellow-100 text-yellow-800': campaign.status === 'paused',
                        'bg-gray-100 text-gray-800': campaign.status === 'draft'
                      }">
                  {{ campaign.status.charAt(0).toUpperCase() + campaign.status.slice(1) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ campaign.budget }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ campaign.created_at }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ campaign.end_date }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdvertiserLayout>
</template> 