<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'
import { PageProps } from '@/types'
import { ref, computed } from 'vue'

defineProps<{
  auth: PageProps['auth'],
  errors: {},
  name?: string
}>()

// Sample data - in a real app, this would come from the backend
const stats = ref({
  earnings: {
    total: '$5,240.80',
    pending: '$1,220.50',
    thisMonth: '$840.25',
    growth: '+14.2%'
  },
  performance: {
    clicks: 12458,
    conversions: 632,
    conversionRate: '5.07%',
    averageCommission: '$8.29'
  }
})

const activeCampaigns = ref([
  { id: 1, name: 'Summer Fashion Sale', advertiser: 'Fashion Store Inc.', commission: '$12 per sale', clicks: 1245, conversions: 78, earnings: '$936.00', category: 'Fashion', image: '/img/campaigns/fashion.jpg' },
  { id: 2, name: 'Smartphone Launch', advertiser: 'TechGadgets', commission: '8% of sale', clicks: 958, conversions: 42, earnings: '$756.00', category: 'Electronics', image: '/img/campaigns/tech.jpg' },
  { id: 3, name: 'Home Fitness Equipment', advertiser: 'FitLife Store', commission: '$25 per sale', clicks: 758, conversions: 35, earnings: '$875.00', category: 'Fitness', image: '/img/campaigns/fitness.jpg' },
  { id: 4, name: 'Online Course Bundle', advertiser: 'LearnMore Academy', commission: '15% of sale', clicks: 625, conversions: 28, earnings: '$504.00', category: 'Education', image: '/img/campaigns/education.jpg' }
])

const recentPayouts = ref([
  { id: 1, amount: '$750.25', date: '2023-05-01', status: 'completed', method: 'Bank Transfer' },
  { id: 2, amount: '$920.50', date: '2023-04-01', status: 'completed', method: 'PayPal' },
  { id: 3, amount: '$680.75', date: '2023-03-01', status: 'completed', method: 'Bank Transfer' }
])

const searchQuery = ref('')
const filteredCampaigns = computed(() => {
  if (searchQuery.value === '') return activeCampaigns.value
  const query = searchQuery.value.toLowerCase()
  return activeCampaigns.value.filter(campaign => 
    campaign.name.toLowerCase().includes(query) || 
    campaign.advertiser.toLowerCase().includes(query) ||
    campaign.category.toLowerCase().includes(query)
  )
})

const selectedTimeRange = ref('This Month')
const timeRanges = ['Today', 'This Week', 'This Month', 'This Year']
</script>

<template>
  <Head title="Affiliate Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <div class="px-4 sm:px-0">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Affiliate Dashboard
        </h2>
        <p class="mt-1 text-sm text-gray-600">Track your earnings and manage campaigns</p>
      </div>
    </template>

    <div class="py-6 sm:py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Time Range Selector -->
        <div class="flex justify-between items-center mb-6">
          <div class="inline-flex shadow-sm rounded-md">
            <button
              v-for="range in timeRanges"
              :key="range"
              @click="selectedTimeRange = range"
              class="px-4 py-2 text-sm font-medium border"
              :class="[
                selectedTimeRange === range 
                  ? 'bg-indigo-600 text-white border-indigo-600 z-10'
                  : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50',
                range === 'Today' ? 'rounded-l-md' : '',
                range === 'This Year' ? 'rounded-r-md' : ''
              ]"
            >
              {{ range }}
            </button>
          </div>
          <div class="flex space-x-3">
            <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Request Payout
            </button>
          </div>
        </div>
    
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
          <!-- Earnings Card -->
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center justify-between">
              <h3 class="text-base font-medium text-gray-900">Earnings Overview</h3>
              <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">
                {{ stats.earnings.growth }}
              </span>
            </div>
            
            <div class="mt-5 grid grid-cols-2 gap-5">
              <div>
                <dt class="text-sm font-medium text-gray-500 truncate">Total Earnings</dt>
                <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.earnings.total }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                <dd class="mt-1 text-2xl font-semibold text-indigo-600">{{ stats.earnings.pending }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500 truncate">This Month</dt>
                <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.earnings.thisMonth }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500 truncate">Next Payout</dt>
                <dd class="mt-1 text-sm font-medium">
                  <span class="px-2 py-1 text-xs font-medium rounded bg-amber-100 text-amber-800">June 1, 2023</span>
                </dd>
              </div>
            </div>
          </div>
          
          <!-- Performance Card -->
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <h3 class="text-base font-medium text-gray-900">Performance Metrics</h3>
            
            <div class="mt-5 grid grid-cols-2 gap-5">
              <div>
                <dt class="text-sm font-medium text-gray-500 truncate">Total Clicks</dt>
                <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.performance.clicks }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500 truncate">Conversions</dt>
                <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.performance.conversions }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500 truncate">Conversion Rate</dt>
                <dd class="mt-1 text-2xl font-semibold text-emerald-600">{{ stats.performance.conversionRate }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500 truncate">Avg. Commission</dt>
                <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.performance.averageCommission }}</dd>
              </div>
            </div>
          </div>
        </div>

        <!-- Active Campaigns -->
        <div class="mt-8 bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
          <div class="p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-900">Your Active Campaigns</h3>
            <div class="mt-3 sm:mt-0 relative">
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search campaigns..."
                class="w-full sm:w-64 pr-10 pl-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              />
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>
          
          <!-- Campaign Grid View -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-gray-200">
            <div v-for="campaign in filteredCampaigns" :key="campaign.id" class="p-4 sm:p-6">
              <div class="flex flex-col h-full">
                <div class="flex-shrink-0 h-36 bg-gray-200 rounded-lg mb-4 overflow-hidden">
                  <img :src="campaign.image" :alt="campaign.name" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='/img/campaigns/placeholder.jpg'" />
                </div>
                <div class="flex-1">
                  <h4 class="text-base font-medium text-gray-900">{{ campaign.name }}</h4>
                  <p class="mt-1 text-sm text-gray-500">{{ campaign.advertiser }}</p>
                  <div class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    {{ campaign.category }}
                  </div>
                  <div class="mt-4 grid grid-cols-2 gap-2 text-sm">
                    <div>
                      <span class="block text-gray-500">Clicks</span>
                      <span class="font-medium text-gray-900">{{ campaign.clicks }}</span>
                    </div>
                    <div>
                      <span class="block text-gray-500">Conversions</span>
                      <span class="font-medium text-gray-900">{{ campaign.conversions }}</span>
                    </div>
                    <div>
                      <span class="block text-gray-500">Earnings</span>
                      <span class="font-medium text-emerald-600">{{ campaign.earnings }}</span>
                    </div>
                    <div>
                      <span class="block text-gray-500">Commission</span>
                      <span class="font-medium text-gray-900">{{ campaign.commission }}</span>
                    </div>
                  </div>
                </div>
                <div class="mt-4 flex space-x-3 pt-4 border-t border-gray-200">
                  <button class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Get Links
                  </button>
                  <button class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Promote
                  </button>
                </div>
              </div>
            </div>
          </div>
          
          <div class="px-4 py-4 sm:px-6 border-t border-gray-200 bg-gray-50 text-right">
            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
              Browse all campaigns<span aria-hidden="true"> &rarr;</span>
            </a>
          </div>
        </div>
        
        <!-- Recent Payouts -->
        <div class="mt-8 bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
          <div class="p-4 sm:p-6 border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-900">Recent Payouts</h3>
          </div>
          
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="payout in recentPayouts" :key="payout.id">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ payout.amount }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ payout.date }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ payout.method }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-green-100 text-green-800">
                      {{ payout.status }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="#" class="text-indigo-600 hover:text-indigo-900">View Receipt</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
        <!-- Marketing Materials -->
        <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="p-4 sm:p-6 border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-900">Marketing Tools</h3>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-200">
            <a href="#" class="block p-6 text-center hover:bg-gray-50">
              <div class="mx-auto h-12 w-12 rounded-full bg-blue-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
              </div>
              <h3 class="mt-3 text-sm font-medium text-gray-900">Affiliate Links</h3>
              <p class="mt-1 text-xs text-gray-500">Generate and manage your tracking links</p>
            </a>
            <a href="#" class="block p-6 text-center hover:bg-gray-50">
              <div class="mx-auto h-12 w-12 rounded-full bg-green-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                </svg>
              </div>
              <h3 class="mt-3 text-sm font-medium text-gray-900">Banners & Creatives</h3>
              <p class="mt-1 text-xs text-gray-500">Access pre-made promotional materials</p>
            </a>
            <a href="#" class="block p-6 text-center hover:bg-gray-50">
              <div class="mx-auto h-12 w-12 rounded-full bg-amber-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
              </div>
              <h3 class="mt-3 text-sm font-medium text-gray-900">Performance Reports</h3>
              <p class="mt-1 text-xs text-gray-500">Advanced analytics and reporting tools</p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style>
/* Add any custom styles here if needed */
</style> 