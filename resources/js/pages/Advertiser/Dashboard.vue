<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AdvertiserLayout from '@/layouts/AdvertiserLayout.vue'
import { PageProps } from '@/types'
import { ref, computed } from 'vue'

defineProps<{
  auth: PageProps['auth'],
  errors: {},
  name?: string
}>()

// Sample data - in a real app, this would come from the backend
const stats = ref({
  campaigns: {
    total: 12,
    active: 8,
    paused: 3,
    draft: 1
  },
  performance: {
    impressions: 168942,
    clicks: 6547,
    conversions: 428,
    budget: '$12,850.00',
    spent: '$5,284.75',
    ctr: '3.87%',
    conversionRate: '6.54%'
  }
})

const activeCampaigns = ref([
  { 
    id: 1, 
    name: 'Summer Fashion Sale', 
    status: 'active', 
    budget: '$2,500.00',
    spent: '$1,245.50',
    impressions: 45280,
    clicks: 2158,
    conversions: 187,
    ctr: '4.8%',
    conversionRate: '8.7%',
    image: '/img/campaigns/fashion.jpg',
    startDate: '2023-05-01',
    endDate: '2023-08-31'
  },
  { 
    id: 2, 
    name: 'New Smartphone Launch', 
    status: 'active', 
    budget: '$5,000.00',
    spent: '$2,340.25',
    impressions: 78520,
    clicks: 3241,
    conversions: 165,
    ctr: '4.1%',
    conversionRate: '5.1%',
    image: '/img/campaigns/tech.jpg',
    startDate: '2023-04-15',
    endDate: '2023-07-15'
  },
  { 
    id: 3, 
    name: 'Home Fitness Equipment', 
    status: 'active', 
    budget: '$1,800.00',
    spent: '$925.75',
    impressions: 28450,
    clicks: 948,
    conversions: 76,
    ctr: '3.3%',
    conversionRate: '8.0%',
    image: '/img/campaigns/fitness.jpg',
    startDate: '2023-04-01',
    endDate: '2023-06-30'
  },
  { 
    id: 4, 
    name: 'Back to School Sale', 
    status: 'paused', 
    budget: '$1,200.00',
    spent: '$450.00',
    impressions: 12540,
    clicks: 684,
    conversions: 32,
    ctr: '5.5%',
    conversionRate: '4.7%',
    image: '/img/campaigns/education.jpg',
    startDate: '2023-07-15',
    endDate: '2023-08-31'
  }
])

const topAffiliates = ref([
  { id: 1, name: 'Sarah Johnson', conversions: 87, earnings: '$2,175.00', conversionRate: '8.2%' },
  { id: 2, name: 'Tech Review Blog', conversions: 64, earnings: '$1,600.00', conversionRate: '7.5%' },
  { id: 3, name: 'Fitness Influencer', conversions: 45, earnings: '$1,125.00', conversionRate: '9.1%' }
])

const recentSales = ref([
  { id: 1, date: '2023-05-20', amount: 'TZS 120,000', affiliate: 'Juma Hassan', code: 'JUMA254', type: 'In-store' },
  { id: 2, date: '2023-05-19', amount: 'TZS 85,000', affiliate: 'Amina Said', code: 'AMINA123', type: 'Online' },
  { id: 3, date: '2023-05-18', amount: 'TZS 250,000', affiliate: 'Daniel Mtui', code: 'DANIEL85', type: 'In-store' },
])

const searchQuery = ref('')
const filteredCampaigns = computed(() => {
  if (searchQuery.value === '') return activeCampaigns.value
  const query = searchQuery.value.toLowerCase()
  return activeCampaigns.value.filter(campaign => 
    campaign.name.toLowerCase().includes(query) || 
    campaign.status.toLowerCase().includes(query)
  )
})

const selectedTimeRange = ref('This Month')
const timeRanges = ['Today', 'This Week', 'This Month', 'This Year']
</script>

<template>
  <Head title="Advertiser Dashboard" />

  <AdvertiserLayout>
    <template #header>
      <div class="px-4 sm:px-0">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Overview Dashboard
        </h2>
        <p class="mt-1 text-sm text-gray-600">Track your business performance and affiliate sales</p>
      </div>
    </template>

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
      <div class="inline-flex shadow-sm rounded-md mb-4 sm:mb-0">
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
        <a href="#" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Download Report
        </a>
        <a href="/advertiser/campaigns/create" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Create Campaign
        </a>
      </div>
    </div>

    <!-- Campaign Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6">
      <!-- Campaign Status Card -->
      <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
        <h3 class="text-base font-medium text-gray-900">Campaign Overview</h3>
        
        <div class="mt-5 grid grid-cols-2 gap-5">
          <div>
            <dt class="text-sm font-medium text-gray-500 truncate">Total Campaigns</dt>
            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.campaigns.total }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500 truncate">Active</dt>
            <dd class="mt-1 text-2xl font-semibold text-emerald-600">{{ stats.campaigns.active }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500 truncate">Paused</dt>
            <dd class="mt-1 text-2xl font-semibold text-amber-500">{{ stats.campaigns.paused }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500 truncate">Draft</dt>
            <dd class="mt-1 text-2xl font-semibold text-gray-500">{{ stats.campaigns.draft }}</dd>
          </div>
        </div>
      </div>
      
      <!-- Budget Overview Card -->
      <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
        <h3 class="text-base font-medium text-gray-900">Budget & Sales Overview</h3>
        
        <div class="mt-5 grid grid-cols-2 gap-5">
          <div>
            <dt class="text-sm font-medium text-gray-500 truncate">Total Budget</dt>
            <dd class="mt-1 text-2xl font-semibold text-gray-900">TZS 12,850,000</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500 truncate">Total Sales</dt>
            <dd class="mt-1 text-2xl font-semibold text-indigo-600">TZS 5,284,750</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500 truncate">From Affiliates</dt>
            <dd class="mt-1 text-2xl font-semibold text-emerald-600">TZS 1,853,000</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500 truncate">Commission Paid</dt>
            <dd class="mt-1 text-2xl font-semibold text-amber-600">TZS 455,000</dd>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Performance Metrics -->
    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100 mb-6">
      <h3 class="text-base font-medium text-gray-900 mb-4">Performance Metrics</h3>
      
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gray-50 rounded-lg p-4">
          <dt class="text-sm font-medium text-gray-500 truncate">Referral Visits</dt>
          <dd class="mt-1 text-xl font-semibold text-gray-900">{{ stats.performance.impressions.toLocaleString() }}</dd>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <dt class="text-sm font-medium text-gray-500 truncate">Total Referrals</dt>
          <dd class="mt-1 text-xl font-semibold text-gray-900">{{ stats.performance.clicks.toLocaleString() }}</dd>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <dt class="text-sm font-medium text-gray-500 truncate">Conversion Rate</dt>
          <dd class="mt-1 text-xl font-semibold text-blue-600">{{ stats.performance.ctr }}</dd>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <dt class="text-sm font-medium text-gray-500 truncate">Completed Sales</dt>
          <dd class="mt-1 text-xl font-semibold text-emerald-600">{{ stats.performance.conversions.toLocaleString() }}</dd>
        </div>
      </div>
    </div>

    <!-- Recent Sales -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 mb-6">
      <div class="p-4 sm:p-6 border-b border-gray-200">
        <h3 class="text-base font-semibold text-gray-900">Recent Affiliate Sales</h3>
      </div>
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Affiliate</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code Used</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
              <th scope="col" class="relative px-6 py-3">
                <span class="sr-only">Actions</span>
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="sale in recentSales" :key="sale.id">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ sale.date }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ sale.amount }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ sale.affiliate }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full bg-indigo-100 text-indigo-800">
                  {{ sale.code }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full" 
                      :class="{
                        'bg-blue-100 text-blue-800': sale.type === 'Online',
                        'bg-green-100 text-green-800': sale.type === 'In-store'
                      }">
                  {{ sale.type }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <a href="#" class="text-indigo-600 hover:text-indigo-900">View Details</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="px-4 py-4 sm:px-6 border-t border-gray-200 bg-gray-50 text-right">
        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
          View all sales<span aria-hidden="true"> &rarr;</span>
        </a>
      </div>
    </div>
    
    <!-- Active Campaigns -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 mb-6">
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
      
      <!-- Campaign Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-200">
        <div v-for="campaign in filteredCampaigns" :key="campaign.id" class="p-4 sm:p-6">
          <div class="flex flex-col h-full">
            <div class="flex items-center justify-between mb-4">
              <h4 class="text-base font-medium text-gray-900">{{ campaign.name }}</h4>
              <span class="px-2.5 py-0.5 text-xs font-medium rounded-full" 
                :class="{
                  'bg-green-100 text-green-800': campaign.status === 'active',
                  'bg-yellow-100 text-yellow-800': campaign.status === 'paused',
                  'bg-gray-100 text-gray-800': campaign.status === 'draft'
                }">
                {{ campaign.status.charAt(0).toUpperCase() + campaign.status.slice(1) }}
              </span>
            </div>
            
            <div class="flex-shrink-0 h-36 bg-gray-200 rounded-lg mb-4 overflow-hidden">
              <img :src="campaign.image" :alt="campaign.name" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='/img/campaigns/placeholder.jpg'" />
            </div>
            
            <div class="flex items-center justify-between mb-2">
              <span class="text-sm text-gray-500">Budget</span>
              <span class="text-sm font-medium text-gray-900">{{ campaign.budget }}</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4">
              <div class="bg-indigo-600 h-1.5 rounded-full" :style="`width: ${(parseFloat(campaign.spent.replace(/[^0-9.-]+/g, '')) / parseFloat(campaign.budget.replace(/[^0-9.-]+/g, '')) * 100).toFixed(0)}%`"></div>
            </div>
            
            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
              <div>
                <span class="block text-gray-500">Referrals</span>
                <span class="font-medium text-gray-900">{{ campaign.clicks.toLocaleString() }}</span>
              </div>
              <div>
                <span class="block text-gray-500">Sales</span>
                <span class="font-medium text-gray-900">{{ campaign.conversions.toLocaleString() }}</span>
              </div>
              <div>
                <span class="block text-gray-500">Refer Rate</span>
                <span class="font-medium text-blue-600">{{ campaign.ctr }}</span>
              </div>
              <div>
                <span class="block text-gray-500">Conv. Rate</span>
                <span class="font-medium text-emerald-600">{{ campaign.conversionRate }}</span>
              </div>
            </div>
            
            <div class="text-xs text-gray-500 mt-auto">
              <span>{{ campaign.startDate }} to {{ campaign.endDate }}</span>
            </div>
            
            <div class="mt-4 flex space-x-3 pt-4 border-t border-gray-200">
              <button class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Edit
              </button>
              <button class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ campaign.status === 'active' ? 'Pause' : 'Activate' }}
              </button>
            </div>
          </div>
        </div>
      </div>
      
      <div class="px-4 py-4 sm:px-6 border-t border-gray-200 bg-gray-50 text-right">
        <a href="/advertiser/campaigns" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
          View all campaigns<span aria-hidden="true"> &rarr;</span>
        </a>
      </div>
    </div>
    
    <!-- Top Affiliates -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 mb-6">
      <div class="p-4 sm:p-6 border-b border-gray-200">
        <h3 class="text-base font-semibold text-gray-900">Top Performing Affiliates</h3>
      </div>
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Affiliate</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conversions</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conversion Rate</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Earnings</th>
              <th scope="col" class="relative px-6 py-3">
                <span class="sr-only">Actions</span>
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="affiliate in topAffiliates" :key="affiliate.id">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ affiliate.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ affiliate.conversions }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 font-medium">{{ affiliate.conversionRate }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-emerald-600 font-medium">{{ affiliate.earnings }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <a href="#" class="text-indigo-600 hover:text-indigo-900">View Details</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="px-4 py-4 sm:px-6 border-t border-gray-200 bg-gray-50 text-right">
        <a href="/advertiser/affiliates" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
          View all affiliates<span aria-hidden="true"> &rarr;</span>
        </a>
      </div>
    </div>
  </AdvertiserLayout>
</template>

<style>
/* Add any custom styles here if needed */
</style> 