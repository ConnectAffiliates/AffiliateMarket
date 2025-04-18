<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'
import { PageProps } from '@/types'
import { ref, computed } from 'vue'

const props = defineProps<{
  auth: PageProps['auth'],
  errors: {},
  sales: any[],
  stats: any
}>()

const searchQuery = ref('')
const statusFilter = ref('all')

const filteredSales = computed(() => {
  let result = props.sales || []
  
  // Filter by status if not "all"
  if (statusFilter.value !== 'all') {
    result = result.filter((sale: any) => sale.status === statusFilter.value)
  }
  
  // Filter by search query
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    result = result.filter((sale: any) => 
      (sale.campaign?.name?.toLowerCase().includes(query)) || 
      (sale.customer_name?.toLowerCase().includes(query)) ||
      (sale.order_id?.toLowerCase().includes(query))
    )
  }
  
  return result
})

const getStatusColor = (status: string) => {
  const colors = {
    'pending': 'bg-yellow-100 text-yellow-800',
    'approved': 'bg-green-100 text-green-800',
    'rejected': 'bg-red-100 text-red-800',
    'flagged': 'bg-orange-100 text-orange-800'
  }
  
  return colors[status as keyof typeof colors] || 'bg-gray-100 text-gray-800'
}

const formatDate = (dateString: string) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}
</script>

<template>
  <Head title="My Sales" />

  <AuthenticatedLayout>
    <template #header>
      <div class="px-4 sm:px-0">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          My Sales
        </h2>
        <p class="mt-1 text-sm text-gray-600">Track your sales and commissions</p>
      </div>
    </template>

    <div class="py-6 sm:py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 sm:gap-6 mb-6">
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <dt class="text-sm font-medium text-gray-500 truncate">Total Sales</dt>
            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ stats?.total || 0 }}</dd>
          </div>
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
            <dd class="mt-1 text-2xl font-semibold text-yellow-600">{{ stats?.pending || 0 }}</dd>
          </div>
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <dt class="text-sm font-medium text-gray-500 truncate">Approved</dt>
            <dd class="mt-1 text-2xl font-semibold text-green-600">{{ stats?.approved || 0 }}</dd>
          </div>
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <dt class="text-sm font-medium text-gray-500 truncate">Total Commission</dt>
            <dd class="mt-1 text-2xl font-semibold text-indigo-600">TZS {{ Number(stats?.totalCommission || 0).toLocaleString() }}</dd>
          </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 mb-6">
          <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-center justify-between">
            <div class="flex space-x-2 mb-4 sm:mb-0">
              <button 
                @click="statusFilter = 'all'" 
                class="px-3 py-2 text-sm font-medium rounded-md"
                :class="statusFilter === 'all' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
              >
                All
              </button>
              <button 
                @click="statusFilter = 'pending'" 
                class="px-3 py-2 text-sm font-medium rounded-md"
                :class="statusFilter === 'pending' ? 'bg-yellow-600 text-white' : 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200'"
              >
                Pending
              </button>
              <button 
                @click="statusFilter = 'approved'" 
                class="px-3 py-2 text-sm font-medium rounded-md"
                :class="statusFilter === 'approved' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200'"
              >
                Approved
              </button>
              <button 
                @click="statusFilter = 'rejected'" 
                class="px-3 py-2 text-sm font-medium rounded-md"
                :class="statusFilter === 'rejected' ? 'bg-red-600 text-white' : 'bg-red-100 text-red-700 hover:bg-red-200'"
              >
                Rejected
              </button>
            </div>
            <div class="w-full sm:w-64 relative">
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search sales..."
                class="w-full pr-10 pl-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              />
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Sales Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commission</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="sale in filteredSales" :key="sale.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ formatDate(sale.created_at) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                      {{ sale.campaign?.name || 'Unknown Campaign' }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ sale.customer_name }}</div>
                    <div class="text-sm text-gray-500">{{ sale.customer_email }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ sale.order_id || '—' }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ sale.formatted_amount || `TZS ${Number(sale.amount).toLocaleString()}` }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-600 font-medium">
                    {{ sale.formatted_commission || `TZS ${Number(sale.commission).toLocaleString()}` }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="getStatusColor(sale.status)">
                      {{ sale.status.charAt(0).toUpperCase() + sale.status.slice(1) }}
                    </span>
                  </td>
                </tr>
                <tr v-if="filteredSales.length === 0">
                  <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                    No sales found matching your filters.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template> 