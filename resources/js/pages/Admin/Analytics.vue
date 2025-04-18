<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'
import { PageProps } from '@/types'
import { ref, computed, onMounted } from 'vue'

interface Summary {
  totalRevenue: number;
  platformFees: number;
  totalPayouts: number;
  pendingPayouts: number;
  totalUsers: number;
  totalAdvertisers: number;
  totalAffiliates: number;
  totalCampaigns: number;
  activeCampaigns: number;
  growthRate: number;
}

interface UserGrowth {
  date: string;
  advertisers: number;
  affiliates: number;
  total: number;
}

interface RevenueData {
  date: string;
  revenue: number;
  fees: number;
  payouts: number;
}

interface Advertiser {
  id: number;
  name: string;
  campaignCount: number;
  spend: number;
  conversions: number;
}

interface Affiliate {
  id: number;
  name: string;
  campaignCount: number;
  earnings: number;
  conversions: number;
}

interface CategoryPerformance {
  category: string;
  campaigns: number;
  spend: number;
  conversions: number;
  conversionRate: number;
}

interface Transaction {
  id: string;
  date: string;
  advertiser: string;
  affiliate: string;
  amount: number;
  status: 'completed' | 'pending';
}

interface StatsData {
  summary: Summary;
  userGrowth: UserGrowth[];
  revenueData: RevenueData[];
  topAdvertisers: Advertiser[];
  topAffiliates: Affiliate[];
  categoryPerformance: CategoryPerformance[];
  recentTransactions: Transaction[];
}

const props = defineProps<{
  auth: PageProps['auth'],
  errors: Record<string, string>,
  stats?: StatsData
}>()

// Sample data - in a real app, this would come from the backend
const stats = ref<StatsData>(props.stats || {
  summary: {
    totalRevenue: 125480000,
    platformFees: 12548000,
    totalPayouts: 112932000,
    pendingPayouts: 27560000,
    totalUsers: 256,
    totalAdvertisers: 45,
    totalAffiliates: 211,
    totalCampaigns: 87,
    activeCampaigns: 68,
    growthRate: 14.5,
  },
  userGrowth: [
    { date: 'Jan 2023', advertisers: 28, affiliates: 145, total: 173 },
    { date: 'Feb 2023', advertisers: 30, affiliates: 152, total: 182 },
    { date: 'Mar 2023', advertisers: 32, affiliates: 160, total: 192 },
    { date: 'Apr 2023', advertisers: 35, affiliates: 172, total: 207 },
    { date: 'May 2023', advertisers: 38, affiliates: 185, total: 223 },
    { date: 'Jun 2023', advertisers: 42, affiliates: 196, total: 238 },
    { date: 'Jul 2023', advertisers: 45, affiliates: 211, total: 256 }
  ],
  revenueData: [
    { date: 'Jan 2023', revenue: 85450000, fees: 8545000, payouts: 76905000 },
    { date: 'Feb 2023', revenue: 93240000, fees: 9324000, payouts: 83916000 },
    { date: 'Mar 2023', revenue: 98760000, fees: 9876000, payouts: 88884000 },
    { date: 'Apr 2023', revenue: 106520000, fees: 10652000, payouts: 95868000 },
    { date: 'May 2023', revenue: 114380000, fees: 11438000, payouts: 102942000 },
    { date: 'Jun 2023', revenue: 119250000, fees: 11925000, payouts: 107325000 },
    { date: 'Jul 2023', revenue: 125480000, fees: 12548000, payouts: 112932000 }
  ],
  topAdvertisers: [
    { id: 1, name: 'TechGadgets', campaignCount: 5, spend: 15850000, conversions: 734 },
    { id: 2, name: 'Fashion Store Inc.', campaignCount: 3, spend: 12450000, conversions: 625 },
    { id: 3, name: 'FitLife Store', campaignCount: 4, spend: 9780000, conversions: 512 },
    { id: 4, name: 'Wanderlust Travels', campaignCount: 2, spend: 8650000, conversions: 423 },
    { id: 5, name: 'Pure Beauty Co.', campaignCount: 3, spend: 7520000, conversions: 378 }
  ],
  topAffiliates: [
    { id: 1, name: 'Digital Marketer Pro', campaignCount: 8, earnings: 8750000, conversions: 412 },
    { id: 2, name: 'Affiliate Master', campaignCount: 6, earnings: 7450000, conversions: 365 },
    { id: 3, name: 'TopPromotions', campaignCount: 7, earnings: 6850000, conversions: 320 },
    { id: 4, name: 'MarketingGurus', campaignCount: 5, earnings: 5920000, conversions: 278 },
    { id: 5, name: 'AffiliateTech', campaignCount: 4, earnings: 4850000, conversions: 215 }
  ],
  categoryPerformance: [
    { category: 'Electronics', campaigns: 18, spend: 28450000, conversions: 1350, conversionRate: 8.2 },
    { category: 'Fashion', campaigns: 15, spend: 22650000, conversions: 1120, conversionRate: 7.8 },
    { category: 'Travel', campaigns: 8, spend: 18750000, conversions: 850, conversionRate: 6.4 },
    { category: 'Beauty', campaigns: 12, spend: 14250000, conversions: 750, conversionRate: 7.2 },
    { category: 'Fitness', campaigns: 11, spend: 12450000, conversions: 620, conversionRate: 6.8 },
    { category: 'Education', campaigns: 7, spend: 9850000, conversions: 480, conversionRate: 6.5 },
    { category: 'Others', campaigns: 16, spend: 19080000, conversions: 880, conversionRate: 5.9 }
  ],
  recentTransactions: [
    { id: 'TX-12345', date: '2023-07-21', advertiser: 'TechGadgets', affiliate: 'Digital Marketer Pro', amount: 1250000, status: 'completed' },
    { id: 'TX-12344', date: '2023-07-20', advertiser: 'Fashion Store Inc.', affiliate: 'Affiliate Master', amount: 875000, status: 'completed' },
    { id: 'TX-12343', date: '2023-07-19', advertiser: 'FitLife Store', affiliate: 'TopPromotions', amount: 950000, status: 'completed' },
    { id: 'TX-12342', date: '2023-07-18', advertiser: 'Wanderlust Travels', affiliate: 'MarketingGurus', amount: 1350000, status: 'pending' },
    { id: 'TX-12341', date: '2023-07-17', advertiser: 'Pure Beauty Co.', affiliate: 'AffiliateTech', amount: 680000, status: 'pending' }
  ]
})

// Date range selection
const dateRanges = ['Last 7 Days', 'Last 30 Days', 'This Month', 'Last Month', 'This Quarter', 'This Year', 'All Time']
const selectedDateRange = ref('This Month')

// Format currency
const formatCurrency = (amount: number, abbreviate = false): string => {
  if (abbreviate) {
    if (amount >= 1000000000) {
      return `TZS ${(amount / 1000000000).toFixed(1)}B`
    } else if (amount >= 1000000) {
      return `TZS ${(amount / 1000000).toFixed(1)}M`
    } else if (amount >= 1000) {
      return `TZS ${(amount / 1000).toFixed(1)}K`
    }
  }
  return `TZS ${amount.toLocaleString()}`
}

// Format percentage
const formatPercentage = (value: number): string => {
  return `${value.toFixed(1)}%`
}

// Create computed properties for visual elements
const userGrowthLabels = computed(() => stats.value.userGrowth.map(item => item.date))
const userGrowthAdvertisers = computed(() => stats.value.userGrowth.map(item => item.advertisers))
const userGrowthAffiliates = computed(() => stats.value.userGrowth.map(item => item.affiliates))
const userGrowthTotal = computed(() => stats.value.userGrowth.map(item => item.total))

const revenueLabels = computed(() => stats.value.revenueData.map(item => item.date))
const revenueTotals = computed(() => stats.value.revenueData.map(item => item.revenue))
const revenueFees = computed(() => stats.value.revenueData.map(item => item.fees))
const revenuePayouts = computed(() => stats.value.revenueData.map(item => item.payouts))

// Calculate percentage change (for current vs previous period)
const calculateChange = (current: number, previous: number): { value: number, positive: boolean } => {
  if (previous === 0) return { value: 100, positive: true }
  const diff = ((current - previous) / previous) * 100
  return {
    value: Math.abs(Math.round(diff * 10) / 10),
    positive: diff >= 0
  }
}

// Generate period changes (comparing with previous period)
const previousPeriodRevenue = 119250000 // This would come from the backend in a real app
const revenueChange = calculateChange(stats.value.summary.totalRevenue, previousPeriodRevenue)

const previousPeriodUsers = 238 // This would come from the backend in a real app
const usersChange = calculateChange(stats.value.summary.totalUsers, previousPeriodUsers)

const previousPeriodCampaigns = 82 // This would come from the backend in a real app
const campaignsChange = calculateChange(stats.value.summary.totalCampaigns, previousPeriodCampaigns)

// Export data to CSV
const exportReport = () => {
  // In a real app, this would trigger a CSV download
  alert('Analytics data would be exported as CSV in a real application')
}

// Print report
const printReport = () => {
  window.print()
}
</script>

<template>
  <Head title="Platform Analytics" />

  <AuthenticatedLayout>
    <template #header>
      <div class="px-4 sm:px-0 flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Platform Analytics
          </h2>
          <p class="mt-1 text-sm text-gray-600">Comprehensive analytics and insights across the platform</p>
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
            @click="exportReport"
            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Export
          </button>
          
          <button 
            @click="printReport"
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
        <!-- Key Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
          <!-- Revenue -->
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center justify-between">
              <h3 class="text-sm font-medium text-gray-500">Total Revenue</h3>
              <span 
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                :class="revenueChange.positive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
              >
                <svg 
                  xmlns="http://www.w3.org/2000/svg" 
                  class="h-3 w-3 mr-1" 
                  :class="revenueChange.positive ? 'text-green-500' : 'text-red-500'"
                  fill="none" 
                  viewBox="0 0 24 24" 
                  stroke="currentColor"
                >
                  <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    :d="revenueChange.positive ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7'" 
                  />
                </svg>
                {{ revenueChange.value }}%
              </span>
            </div>
            <div class="mt-2 flex items-baseline">
              <p class="text-2xl font-semibold text-gray-900">
                {{ formatCurrency(stats.summary.totalRevenue, true) }}
              </p>
              <p class="ml-2 text-sm font-medium text-gray-500">from last month</p>
            </div>
            <div class="mt-1 text-xs text-gray-500">
              Platform fees: {{ formatCurrency(stats.summary.platformFees, true) }}
            </div>
          </div>
          
          <!-- Users -->
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center justify-between">
              <h3 class="text-sm font-medium text-gray-500">Total Users</h3>
              <span 
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                :class="usersChange.positive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
              >
                <svg 
                  xmlns="http://www.w3.org/2000/svg" 
                  class="h-3 w-3 mr-1" 
                  :class="usersChange.positive ? 'text-green-500' : 'text-red-500'"
                  fill="none" 
                  viewBox="0 0 24 24" 
                  stroke="currentColor"
                >
                  <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    :d="usersChange.positive ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7'" 
                  />
                </svg>
                {{ usersChange.value }}%
              </span>
            </div>
            <div class="mt-2 flex items-baseline">
              <p class="text-2xl font-semibold text-gray-900">
                {{ stats.summary.totalUsers }}
              </p>
              <p class="ml-2 text-sm font-medium text-gray-500">registered users</p>
            </div>
            <div class="mt-1 text-xs text-gray-500">
              {{ stats.summary.totalAdvertisers }} Advertisers, {{ stats.summary.totalAffiliates }} Affiliates
            </div>
          </div>
          
          <!-- Campaigns -->
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center justify-between">
              <h3 class="text-sm font-medium text-gray-500">Campaigns</h3>
              <span 
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                :class="campaignsChange.positive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
              >
                <svg 
                  xmlns="http://www.w3.org/2000/svg" 
                  class="h-3 w-3 mr-1" 
                  :class="campaignsChange.positive ? 'text-green-500' : 'text-red-500'"
                  fill="none" 
                  viewBox="0 0 24 24" 
                  stroke="currentColor"
                >
                  <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    :d="campaignsChange.positive ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7'" 
                  />
                </svg>
                {{ campaignsChange.value }}%
              </span>
            </div>
            <div class="mt-2 flex items-baseline">
              <p class="text-2xl font-semibold text-gray-900">
                {{ stats.summary.totalCampaigns }}
              </p>
              <p class="ml-2 text-sm font-medium text-gray-500">total campaigns</p>
            </div>
            <div class="mt-1 text-xs text-gray-500">
              {{ stats.summary.activeCampaigns }} active campaigns
            </div>
          </div>
          
          <!-- Payouts -->
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center justify-between">
              <h3 class="text-sm font-medium text-gray-500">Payouts</h3>
              <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                {{ formatPercentage((stats.summary.totalPayouts / stats.summary.totalRevenue) * 100) }} of revenue
              </span>
            </div>
            <div class="mt-2 flex items-baseline">
              <p class="text-2xl font-semibold text-gray-900">
                {{ formatCurrency(stats.summary.totalPayouts, true) }}
              </p>
              <p class="ml-2 text-sm font-medium text-gray-500">paid to affiliates</p>
            </div>
            <div class="mt-1 text-xs text-gray-500">
              Pending: {{ formatCurrency(stats.summary.pendingPayouts, true) }}
            </div>
          </div>
        </div>
        
        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
          <!-- User Growth Chart -->
          <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="p-4 sm:p-6 border-b border-gray-200">
              <div class="flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-900">User Growth</h3>
                <div class="inline-flex items-center space-x-2">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full mr-1"></span>
                    Total
                  </span>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>
                    Affiliates
                  </span>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-1"></span>
                    Advertisers
                  </span>
                </div>
              </div>
            </div>
            
            <!-- This would be a real chart component in a real app -->
            <div class="p-4 sm:p-6">
              <div class="h-64 w-full flex items-center justify-center bg-gray-50 rounded-lg">
                <div class="text-center">
                  <p class="text-sm text-gray-500">
                    User growth chart would be displayed here.
                  </p>
                  <p class="mt-1 text-xs text-gray-400">
                    (Using a chart library like Chart.js, ApexCharts, or echarts)
                  </p>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Revenue Chart -->
          <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="p-4 sm:p-6 border-b border-gray-200">
              <div class="flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-900">Revenue Trends</h3>
                <div class="inline-flex items-center space-x-2">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full mr-1"></span>
                    Total
                  </span>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>
                    Payouts
                  </span>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                    <span class="w-2 h-2 bg-amber-500 rounded-full mr-1"></span>
                    Fees
                  </span>
                </div>
              </div>
            </div>
            
            <!-- This would be a real chart component in a real app -->
            <div class="p-4 sm:p-6">
              <div class="h-64 w-full flex items-center justify-center bg-gray-50 rounded-lg">
                <div class="text-center">
                  <p class="text-sm text-gray-500">
                    Revenue trends chart would be displayed here.
                  </p>
                  <p class="mt-1 text-xs text-gray-400">
                    (Using a chart library like Chart.js, ApexCharts, or echarts)
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Top Performers and Categories Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
          <!-- Top Advertisers -->
          <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="p-4 sm:p-6 border-b border-gray-200">
              <h3 class="text-base font-semibold text-gray-900">Top Advertisers</h3>
            </div>
            
            <div class="divide-y divide-gray-200">
              <div v-for="advertiser in stats.topAdvertisers" :key="advertiser.id" class="p-4 sm:p-6">
                <div class="flex items-center justify-between">
                  <div>
                    <h4 class="text-sm font-medium text-gray-900">{{ advertiser.name }}</h4>
                    <div class="mt-1 text-xs text-gray-500">
                      {{ advertiser.campaignCount }} campaigns
                    </div>
                  </div>
                  <div class="text-right">
                    <div class="text-sm font-semibold text-gray-900">{{ formatCurrency(advertiser.spend, true) }}</div>
                    <div class="mt-1 text-xs text-gray-500">
                      {{ advertiser.conversions }} conversions
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="p-4 border-t border-gray-200 bg-gray-50 text-right">
              <a href="/admin/users?role=advertiser" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                View all advertisers<span aria-hidden="true"> &rarr;</span>
              </a>
            </div>
          </div>
          
          <!-- Top Affiliates -->
          <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="p-4 sm:p-6 border-b border-gray-200">
              <h3 class="text-base font-semibold text-gray-900">Top Affiliates</h3>
            </div>
            
            <div class="divide-y divide-gray-200">
              <div v-for="affiliate in stats.topAffiliates" :key="affiliate.id" class="p-4 sm:p-6">
                <div class="flex items-center justify-between">
                  <div>
                    <h4 class="text-sm font-medium text-gray-900">{{ affiliate.name }}</h4>
                    <div class="mt-1 text-xs text-gray-500">
                      {{ affiliate.campaignCount }} campaigns
                    </div>
                  </div>
                  <div class="text-right">
                    <div class="text-sm font-semibold text-gray-900">{{ formatCurrency(affiliate.earnings, true) }}</div>
                    <div class="mt-1 text-xs text-gray-500">
                      {{ affiliate.conversions }} conversions
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="p-4 border-t border-gray-200 bg-gray-50 text-right">
              <a href="/admin/users?role=affiliate" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                View all affiliates<span aria-hidden="true"> &rarr;</span>
              </a>
            </div>
          </div>
          
          <!-- Category Performance -->
          <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="p-4 sm:p-6 border-b border-gray-200">
              <h3 class="text-base font-semibold text-gray-900">Category Performance</h3>
            </div>
            
            <div class="divide-y divide-gray-200">
              <div v-for="category in stats.categoryPerformance" :key="category.category" class="p-4 sm:p-6">
                <div class="flex items-center justify-between mb-2">
                  <div>
                    <h4 class="text-sm font-medium text-gray-900">{{ category.category }}</h4>
                    <div class="mt-1 text-xs text-gray-500">
                      {{ category.campaigns }} campaigns
                    </div>
                  </div>
                  <div class="text-right">
                    <div class="text-sm font-semibold text-gray-900">{{ formatCurrency(category.spend, true) }}</div>
                    <div class="mt-1 text-xs text-gray-500">
                      {{ category.conversions }} conversions ({{ formatPercentage(category.conversionRate) }})
                    </div>
                  </div>
                </div>
                
                <!-- Performance bar -->
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                  <div 
                    class="bg-indigo-600 h-2.5 rounded-full" 
                    :style="`width: ${category.conversionRate * 10}%`"
                  ></div>
                </div>
              </div>
            </div>
            
            <div class="p-4 border-t border-gray-200 bg-gray-50 text-right">
              <a href="/admin/campaigns" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                View all campaigns<span aria-hidden="true"> &rarr;</span>
              </a>
            </div>
          </div>
        </div>
        
        <!-- Recent Transactions -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
          <div class="p-4 sm:p-6 border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-900">Recent Transactions</h3>
          </div>
          
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Advertiser</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Affiliate</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="transaction in stats.recentTransactions" :key="transaction.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600">
                    {{ transaction.id }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ transaction.date }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ transaction.advertiser }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ transaction.affiliate }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ formatCurrency(transaction.amount) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full"
                          :class="{
                            'bg-green-100 text-green-800': transaction.status === 'completed',
                            'bg-yellow-100 text-yellow-800': transaction.status === 'pending'
                          }">
                      {{ transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1) }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          
          <div class="p-4 border-t border-gray-200 bg-gray-50 text-right">
            <a href="/admin/transactions" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
              View all transactions<span aria-hidden="true"> &rarr;</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template> 