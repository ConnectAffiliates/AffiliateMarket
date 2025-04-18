<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AdvertiserLayout from '@/layouts/AdvertiserLayout.vue'
import { PageProps } from '@/types'
import { ref, computed } from 'vue'

defineProps<{
  auth: PageProps['auth'],
  errors: {}
}>()

const searchQuery = ref('')
const filterStatus = ref('all')

const affiliates = ref([
    {
        id: 1,
    name: 'Amina Said', 
    email: 'amina@example.com', 
    phone: '+255 712 345 678',
    joined_date: '2023-03-15',
        campaigns: 3,
    total_sales: 'TZS 850,000',
    commission_paid: 'TZS 85,000',
    status: 'active'
    },
    {
        id: 2,
    name: 'John Mbwana', 
    email: 'john@example.com', 
    phone: '+255 756 789 012',
    joined_date: '2023-02-20',
    campaigns: 2,
    total_sales: 'TZS 1,200,000',
    commission_paid: 'TZS 120,000',
    status: 'active'
  },
  { 
    id: 3, 
    name: 'Grace Mushi', 
    email: 'grace@example.com', 
    phone: '+255 789 123 456',
    joined_date: '2023-04-05',
    campaigns: 1,
    total_sales: 'TZS 650,000',
    commission_paid: 'TZS 65,000',
    status: 'active'
  },
  { 
    id: 4, 
    name: 'David Kyando', 
    email: 'david@example.com', 
    phone: '+255 732 567 890',
    joined_date: '2023-01-10',
        campaigns: 0,
    total_sales: 'TZS 0',
    commission_paid: 'TZS 0',
    status: 'inactive'
  }
])

const filteredAffiliates = computed(() => {
  let filtered = affiliates.value

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(affiliate => 
      affiliate.name.toLowerCase().includes(query) ||
      affiliate.email.toLowerCase().includes(query) ||
      affiliate.phone.includes(query)
    )
  }

  if (filterStatus.value !== 'all') {
    filtered = filtered.filter(affiliate => affiliate.status === filterStatus.value)
  }

  return filtered
})

const inviteAffiliate = () => {
  // Placeholder for invite functionality
  alert('Invite affiliate functionality would appear here')
}
</script>

<template>
  <Head title="Affiliates" />

  <AdvertiserLayout>
        <template #header>
      <div class="flex justify-between items-center px-4 sm:px-0">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Affiliates
          </h2>
          <p class="mt-1 text-sm text-gray-600">Manage your affiliate partners</p>
        </div>
        <button 
          @click="inviteAffiliate"
          class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
                    Invite Affiliate
        </button>
            </div>
        </template>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
      <!-- Filters -->
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <div class="w-full md:w-1/3">
            <label for="search" class="sr-only">Search</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
                                        </div>
              <input
                id="search"
                v-model="searchQuery"
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                placeholder="Search affiliates"
                type="search"
              />
            </div>
          </div>
          
          <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-700">Status:</span>
            <select
              v-model="filterStatus"
              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
            >
              <option value="all">All</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
            </div>
        </div>
      </div>
      
      <!-- Affiliates Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaigns</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Sales</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commission Paid</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="affiliate in filteredAffiliates" :key="affiliate.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ affiliate.name }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-500">{{ affiliate.email }}</div>
                <div class="text-sm text-gray-500">{{ affiliate.phone }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ affiliate.joined_date }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ affiliate.campaigns }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ affiliate.total_sales }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ affiliate.commission_paid }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span 
                  class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full"
                  :class="{
                    'bg-green-100 text-green-800': affiliate.status === 'active',
                    'bg-gray-100 text-gray-800': affiliate.status === 'inactive'
                  }"
                >
                  {{ affiliate.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <button class="text-indigo-600 hover:text-indigo-900 mr-2">View</button>
                <button 
                  :class="{
                    'text-red-600 hover:text-red-900': affiliate.status === 'active',
                    'text-green-600 hover:text-green-900': affiliate.status === 'inactive'
                  }"
                >
                  {{ affiliate.status === 'active' ? 'Deactivate' : 'Activate' }}
                </button>
              </td>
            </tr>
            
            <tr v-if="filteredAffiliates.length === 0">
              <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                No affiliates found matching your criteria
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdvertiserLayout>
</template> 