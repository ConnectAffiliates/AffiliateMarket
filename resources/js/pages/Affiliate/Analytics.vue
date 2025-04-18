<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'
import { PageProps } from '@/types'
import { ref, computed } from 'vue'

const props = defineProps<{
  auth: PageProps['auth'],
  errors: {},
  analytics?: any
}>()

// Sample data - in a real app, this would come from the backend
const analyticsData = ref(props.analytics || {
  summary: {
    totalClicks: 8574,
    totalConversions: 423,
    totalEarnings: 5842000, // in TZS
    conversionRate: '4.93%',
    pendingPayouts: 1250000,
    averageEPC: 681, // Earnings per click
  },
  trends: {
    clicks: [320, 450, 280, 390, 550, 460, 380, 690, 820, 780, 850, 605],
    conversions: [18, 24, 16, 21, 32, 28, 22, 38, 45, 40, 50, 39],
    earnings: [234000, 312000, 208000, 273000, 416000, 364000, 286000, 494000, 585000, 520000, 650000, 507000],
    months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
  },
  topCampaigns: [
    { 
      id: 1, 
      name: 'Smartphone Launch', 
      clicks: 2340, 
      conversions: 187, 
      conversionRate: '7.99%',
      earnings: 1496000,
      epc: 639,
      image: '/img/campaigns/tech.jpg'
    },
    { 
      id: 2, 
      name: 'Summer Fashion Sale', 
      clicks: 1870, 
      conversions: 112, 
      conversionRate: '5.99%',
      earnings: 1344000,
      epc: 719,
      image: '/img/campaigns/fashion.jpg'
    },
    { 
      id: 3, 
      name: 'Home Fitness Equipment', 
      clicks: 1480, 
      conversions: 74, 
      conversionRate: '5.00%',
      earnings: 1850000,
      epc: 1250,
      image: '/img/campaigns/fitness.jpg'
    }
  ],
  topReferrals: [
    { code: 'TECHGADGET', clicks: 1250, conversions: 100, conversionRate: '8.00%', earnings: 800000 },
    { code: 'SUMMER24JD', clicks: 980, conversions: 60, conversionRate: '6.12%', earnings: 720000 },
    { code: 'FITLIFE25', clicks: 740, conversions: 45, conversionRate: '6.08%', earnings: 1125000 }
  ],
  trafficSources: [
    { source: 'Social Media', clicks: 3840, share: 44.79 },
    { source: 'Blog/Website', clicks: 2150, share: 25.08 },
    { source: 'Email', clicks: 1420, share: 16.56 },
    { source: 'Direct', clicks: 750, share: 8.75 },
    { source: 'Other', clicks: 414, share: 4.83 }
  ],
  geographicData: [
    { region: 'Dar es Salaam', clicks: 2580, conversions: 155, conversionRate: '6.01%' },
    { region: 'Arusha', clicks: 1420, conversions: 80, conversionRate: '5.63%' },
    { region: 'Mwanza', clicks: 980, conversions: 45, conversionRate: '4.59%' },
    { region: 'Zanzibar', clicks: 720, conversions: 32, conversionRate: '4.44%' },
    { region: 'Other', clicks: 2874, conversions: 111, conversionRate: '3.86%' }
  ]
})

// Date range selection
const dateRanges = ['Last 7 Days', 'Last 30 Days', 'This Month', 'Last Month', 'This Year', 'Custom']
const selectedDateRange = ref('Last 30 Days')

// Format currency
const formatCurrency = (amount: number, abbreviate = false): string => {
  if (abbreviate) {
    if (amount >= 1000000) {
      return `TZS ${(amount / 1000000).toFixed(1)}M`
    } else if (amount >= 1000) {
      return `TZS ${(amount / 1000).toFixed(1)}K`
    }
  }
  return `TZS ${amount.toLocaleString()}`
}

// Calculate difference percentage (for trends)
const calculateDifference = (current: number, previous: number): { value: number, positive: boolean } => {
  if (previous === 0) return { value: 100, positive: true }
  const diff = ((current - previous) / previous) * 100
  return {
    value: Math.abs(Math.round(diff * 10) / 10),
    positive: diff >= 0
  }
}

// Create "mock" trend calculations
const trends = {
  clicks: calculateDifference(analyticsData.value.summary.totalClicks, 7820),
  conversions: calculateDifference(analyticsData.value.summary.totalConversions, 385),
  earnings: calculateDifference(analyticsData.value.summary.totalEarnings, 5240000)
}

// Export data to CSV
const exportAnalytics = () => {
  alert('Analytics data would be exported as CSV file in a real application')
}

// Print report
const printAnalytics = () => {
  window.print()
}
</script>

<template>
  <Head title="Affiliate Analytics" />

  <AuthenticatedLayout>
    <template #header>
      <div class="px-4 sm:px-0 flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Analytics Dashboard
          </h2>
          <p class="mt-1 text-sm text-gray-600">Track your performance metrics and optimize your campaigns</p>
        </div>
        <div class="flex items-center space-x-3">
          <div class="relative">
            <select 
              v-model="selectedDateRange"
              class="pr-10 pl-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
            >
              <option v-for="range in dateRanges" :key="range" :value="range">
                {{ range }}
              </option>
            </select>
          </div>
          
          <button 
            @click="exportAnalytics"
            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Export
          </button>
          
          <button 
            @click="printAnalytics"
            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Print
          </button>
        </div>
      </div>
    </template>

    <div class="py-6 sm:py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
          <!-- Clicks -->
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center justify-between">
              <h3 class="text-sm font-medium text-gray-500">Total Clicks</h3>
              <span 
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                :class="trends.clicks.positive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
              >
                <svg 
                  xmlns="http://www.w3.org/2000/svg" 
                  class="h-3 w-3 mr-1" 
                  :class="trends.clicks.positive ? 'text-green-500' : 'text-red-500'"
                  fill="none" 
                  viewBox="0 0 24 24" 
                  stroke="currentColor"
                >
                  <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    :d="trends.clicks.positive ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7'" 
                  />
                </svg>
                {{ trends.clicks.value }}%
              </span>
            </div>
            <div class="mt-2 flex items-baseline">
              <p class="text-2xl font-semibold text-gray-900">
                {{ analyticsData.summary.totalClicks.toLocaleString() }}
              </p>
              <p class="ml-2 text-sm font-medium text-gray-500">from last period</p>
            </div>
          </div>
          
          <!-- Conversions -->
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center justify-between">
              <h3 class="text-sm font-medium text-gray-500">Conversions</h3>
              <span 
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                :class="trends.conversions.positive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
              >
                <svg 
                  xmlns="http://www.w3.org/2000/svg" 
                  class="h-3 w-3 mr-1" 
                  :class="trends.conversions.positive ? 'text-green-500' : 'text-red-500'"
                  fill="none" 
                  viewBox="0 0 24 24" 
                  stroke="currentColor"
                >
                  <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    :d="trends.conversions.positive ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7'" 
                  />
                </svg>
                {{ trends.conversions.value }}%
              </span>
            </div>
            <div class="mt-2 flex items-baseline">
              <p class="text-2xl font-semibold text-gray-900">
                {{ analyticsData.summary.totalConversions.toLocaleString() }}
              </p>
              <p class="ml-2 text-sm font-medium text-gray-500">
                ({{ analyticsData.summary.conversionRate }} rate)
              </p>
            </div>
          </div>
          
          <!-- Earnings -->
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center justify-between">
              <h3 class="text-sm font-medium text-gray-500">Total Earnings</h3>
              <span 
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                :class="trends.earnings.positive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
              >
                <svg 
                  xmlns="http://www.w3.org/2000/svg" 
                  class="h-3 w-3 mr-1" 
                  :class="trends.earnings.positive ? 'text-green-500' : 'text-red-500'"
                  fill="none" 
                  viewBox="0 0 24 24" 
                  stroke="currentColor"
                >
                  <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    :d="trends.earnings.positive ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7'" 
                  />
                </svg>
                {{ trends.earnings.value }}%
              </span>
            </div>
            <div class="mt-2 flex items-baseline">
              <p class="text-2xl font-semibold text-emerald-600">
                {{ formatCurrency(analyticsData.summary.totalEarnings, true) }}
              </p>
              <p class="ml-2 text-sm font-medium text-gray-500">
                ({{ formatCurrency(analyticsData.summary.averageEPC) }}/click)
              </p>
            </div>
          </div>
          
          <!-- Pending Payouts -->
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center justify-between">
              <h3 class="text-sm font-medium text-gray-500">Pending Payouts</h3>
              <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                Next: Jun 1, 2024
              </span>
            </div>
            <div class="mt-2">
              <p class="text-2xl font-semibold text-indigo-600">
                {{ formatCurrency(analyticsData.summary.pendingPayouts, true) }}
              </p>
            </div>
          </div>
        </div>
        
        <!-- Performance Chart (placeholder for a real chart) -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 mb-6">
          <div class="p-4 sm:p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
              <h3 class="text-base font-semibold text-gray-900">Performance Trends</h3>
              <div class="inline-flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                  <span class="w-2 h-2 bg-blue-500 rounded-full mr-1"></span>
                  Clicks
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                  <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>
                  Conversions
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                  <span class="w-2 h-2 bg-indigo-500 rounded-full mr-1"></span>
                  Earnings
                </span>
              </div>
            </div>
          </div>
          
          <!-- This would be a real chart component in a real app -->
          <div class="p-4 sm:p-6">
            <div class="h-64 w-full flex items-center justify-center bg-gray-50 rounded-lg">
              <div class="text-center">
                <p class="text-sm text-gray-500">
                  Performance trend visualization would be displayed here.
                </p>
                <p class="mt-1 text-xs text-gray-400">
                  (Using a chart library like Chart.js, ApexCharts, or echarts)
                </p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Two Column Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
          <!-- Top Campaigns -->
          <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="p-4 sm:p-6 border-b border-gray-200">
              <h3 class="text-base font-semibold text-gray-900">Top Performing Campaigns</h3>
            </div>
            
            <div class="divide-y divide-gray-200">
              <div v-for="campaign in analyticsData.topCampaigns" :key="campaign.id" class="p-4 sm:p-6">
                <div class="flex items-start">
                  <div class="flex-shrink-0 h-12 w-12 rounded-md overflow-hidden bg-gray-100">
                    <img :src="campaign.image" :alt="campaign.name" class="h-12 w-12 object-cover" onerror="this.onerror=null; this.src='/img/campaigns/placeholder.jpg'" />
                  </div>
                  <div class="ml-4 flex-1">
                    <h4 class="text-sm font-medium text-gray-900">{{ campaign.name }}</h4>
                    <div class="mt-1 grid grid-cols-3 gap-1">
                      <div>
                        <p class="text-xs text-gray-500">Clicks</p>
                        <p class="text-sm font-semibold text-gray-900">{{ campaign.clicks.toLocaleString() }}</p>
                      </div>
                      <div>
                        <p class="text-xs text-gray-500">Conv. Rate</p>
                        <p class="text-sm font-semibold text-gray-900">{{ campaign.conversionRate }}</p>
                      </div>
                      <div>
                        <p class="text-xs text-gray-500">Earnings</p>
                        <p class="text-sm font-semibold text-emerald-600">{{ formatCurrency(campaign.earnings, true) }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="p-4 border-t border-gray-200 bg-gray-50 text-right">
              <a href="/affiliate/campaigns" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                View all campaigns<span aria-hidden="true"> &rarr;</span>
              </a>
            </div>
          </div>
          
          <!-- Traffic Sources -->
          <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="p-4 sm:p-6 border-b border-gray-200">
              <h3 class="text-base font-semibold text-gray-900">Traffic Sources</h3>
            </div>
            
            <!-- This would be a real pie chart in a real app -->
            <div class="p-4 sm:px-6 py-4">
              <div class="h-48 w-full flex items-center justify-center bg-gray-50 rounded-lg mb-4">
                <div class="text-center">
                  <p class="text-sm text-gray-500">
                    Traffic source distribution visualization would be displayed here.
                  </p>
                </div>
              </div>
              
              <div class="space-y-2">
                <div v-for="source in analyticsData.trafficSources" :key="source.source" class="flex items-center">
                  <div 
                    class="w-3 h-3 rounded-full flex-shrink-0"
                    :class="{
                      'bg-indigo-500': source.source === 'Social Media',
                      'bg-blue-500': source.source === 'Blog/Website',
                      'bg-green-500': source.source === 'Email',
                      'bg-amber-500': source.source === 'Direct',
                      'bg-gray-500': source.source === 'Other'
                    }"
                  ></div>
                  <div class="ml-2 flex-1 flex justify-between items-center">
                    <span class="text-sm text-gray-900">{{ source.source }}</span>
                    <span class="text-sm text-gray-500">{{ source.clicks.toLocaleString() }} clicks ({{ source.share }}%)</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Geographic Performance -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 mb-6">
          <div class="p-4 sm:p-6 border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-900">Geographic Performance</h3>
          </div>
          
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Region</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clicks</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conversions</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conversion Rate</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="region in analyticsData.geographicData" :key="region.region" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ region.region }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ region.clicks.toLocaleString() }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ region.conversions }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ region.conversionRate }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                      <div 
                        class="bg-indigo-600 h-2.5 rounded-full" 
                        :style="`width: ${parseFloat(region.conversionRate) * 10}%`"
                      ></div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
        <!-- Top Referral Links -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
          <div class="p-4 sm:p-6 border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-900">Top Performing Referral Links</h3>
          </div>
          
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referral Code</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clicks</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conversions</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conversion Rate</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Earnings</th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="referral in analyticsData.topReferrals" :key="referral.code" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-indigo-600">{{ referral.code }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ referral.clicks.toLocaleString() }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ referral.conversions }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ referral.conversionRate }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-emerald-600">{{ formatCurrency(referral.earnings) }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a 
                      :href="`/affiliate/links?ref=${referral.code}`" 
                      class="text-indigo-600 hover:text-indigo-900"
                    >
                      Details
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          
          <div class="p-4 border-t border-gray-200 bg-gray-50 text-right">
            <a href="/affiliate/links" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
              View all referral links<span aria-hidden="true"> &rarr;</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template> 