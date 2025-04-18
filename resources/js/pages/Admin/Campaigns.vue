<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'
import { PageProps } from '@/types'
import { ref, computed, watch } from 'vue'
import { toastSuccess, toastError } from '@/utils/toast'

interface Props {
  auth: {
    user: {
      name: string
      email: string
    }
  }
  errors: Record<string, string>
  campaigns?: Campaign[]
}

interface Campaign {
  id: number
  name: string
  image: string
  description: string
  advertiser: string
  advertiser_id: number
  category: string
  budget: number
  total_spent: number
  commission_type: string
  commission_value: number
  status: string
  start_date: string
  end_date: string
  impressions: number
  clicks: number
  conversions: number
  created_at?: string
  updated_at?: string
}

const props = defineProps<Props>()

// Sample campaign data
const campaigns = ref<Campaign[]>(props.campaigns || [
  { 
    id: 1, 
    name: 'Summer Fashion Sale', 
    advertiser: 'Fashion Store Inc.',
    advertiser_id: 101,
    description: 'Promote our summer fashion collection with exclusive discounts for your audience.',
    budget: 2500000,
    commission_type: 'fixed',
    commission_value: 12,
    category: 'Fashion',
    status: 'active',
    created_at: '2023-05-01',
    start_date: '2023-06-01',
    end_date: '2023-08-31',
    impressions: 12500,
    clicks: 1850,
    conversions: 132,
    total_spent: 1584000,
    image: '/img/campaigns/fashion.jpg'
  },
  { 
    id: 2, 
    name: 'Smartphone Launch', 
    advertiser: 'TechGadgets',
    advertiser_id: 102,
    description: 'Be among the first to promote our new smartphone model with competitive commissions.',
    budget: 5000000,
    commission_type: 'percentage',
    commission_value: 8,
    category: 'Electronics',
    status: 'active',
    created_at: '2023-04-15',
    start_date: '2023-05-01',
    end_date: '2023-07-15',
    impressions: 28700,
    clicks: 3450,
    conversions: 207,
    total_spent: 2484000,
    image: '/img/campaigns/tech.jpg'
  },
  { 
    id: 3, 
    name: 'Home Fitness Equipment', 
    advertiser: 'FitLife Store',
    advertiser_id: 103,
    description: 'Help your audience stay fit at home with our premium exercise equipment.',
    budget: 1800000,
    commission_type: 'fixed',
    commission_value: 25,
    category: 'Fitness',
    status: 'active',
    created_at: '2023-04-01',
    start_date: '2023-04-15',
    end_date: '2023-06-30',
    impressions: 19200,
    clicks: 2170,
    conversions: 98,
    total_spent: 2450000,
    image: '/img/campaigns/fitness.jpg'
  },
  { 
    id: 4, 
    name: 'Back to School Sale', 
    advertiser: 'EduSupplies',
    advertiser_id: 104,
    description: 'Promote our back to school supplies with great commissions and conversion rates.',
    budget: 1200000,
    commission_type: 'percentage',
    commission_value: 10,
    category: 'Education',
    status: 'pending',
    created_at: '2023-07-15',
    start_date: '2023-08-01',
    end_date: '2023-08-31',
    impressions: 0,
    clicks: 0,
    conversions: 0,
    total_spent: 0,
    image: '/img/campaigns/education.jpg'
  },
  { 
    id: 5, 
    name: 'Travel Package Deals', 
    advertiser: 'Wanderlust Travels',
    advertiser_id: 105,
    description: 'Exotic travel packages at exclusive rates for your audience with high commission.',
    budget: 3000000,
    commission_type: 'percentage',
    commission_value: 12,
    category: 'Travel',
    status: 'pending',
    created_at: '2023-07-10',
    start_date: '2023-08-01',
    end_date: '2023-10-31',
    impressions: 0,
    clicks: 0,
    conversions: 0,
    total_spent: 0,
    image: '/img/campaigns/travel.jpg'
  }
])

// Filters
const filters = ref({
  search: '',
  status: 'all',
  category: 'all',
  advertiser: 'all'
})

// Modal state
const isDetailsModalOpen = ref(false)
const selectedCampaign = ref<Campaign | null>(null)

// Get unique categories from campaigns
const categories = computed(() => {
  const uniqueCategories = ['all', ...new Set(campaigns.value.map(campaign => campaign.category))]
  return uniqueCategories
})

// Get unique advertisers from campaigns
const advertisers = computed(() => {
  const uniqueAdvertisers = ['all', ...new Set(campaigns.value.map(campaign => campaign.advertiser))]
  return uniqueAdvertisers
})

// Filter campaigns based on filters
const filteredCampaigns = computed(() => {
  return campaigns.value.filter(campaign => {
    // Filter by status
    if (filters.value.status !== 'all' && campaign.status !== filters.value.status) return false
    
    // Filter by category
    if (filters.value.category !== 'all' && campaign.category !== filters.value.category) return false
    
    // Filter by advertiser
    if (filters.value.advertiser !== 'all' && campaign.advertiser !== filters.value.advertiser) return false
    
    // Filter by search
    if (filters.value.search) {
      const searchLower = filters.value.search.toLowerCase()
      return (
        campaign.name.toLowerCase().includes(searchLower) ||
        campaign.description.toLowerCase().includes(searchLower) ||
        campaign.advertiser.toLowerCase().includes(searchLower)
      )
    }
    
    return true
  })
})

// Format currency for display
const formatCurrency = (value: number): string => {
  return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(value)
}

// Format commission type and value
const formatCommission = (type: string, value: number): string => {
  if (type === 'percentage') {
    return `${value}% of sale`
  } else if (type === 'fixed') {
    return `${formatCurrency(value)} per sale`
  }
  return `${value} (${type})`
}

// Show campaign details in modal
const viewCampaignDetails = (campaign: Campaign) => {
  selectedCampaign.value = campaign
  isDetailsModalOpen.value = true
}

// Approve campaign
const approveCampaign = (campaign: Campaign) => {
  // In a real app, this would call the API
  try {
    const campaignIndex = campaigns.value.findIndex(c => c.id === campaign.id)
    if (campaignIndex !== -1) {
      campaigns.value[campaignIndex].status = 'active'
      toastSuccess('Campaign approved')
    }
    isDetailsModalOpen.value = false
  } catch (error) {
    toastError('Error approving campaign')
  }
}

// Reject campaign
const rejectCampaign = (campaign: Campaign) => {
  // In a real app, this would call the API
  try {
    const campaignIndex = campaigns.value.findIndex(c => c.id === campaign.id)
    if (campaignIndex !== -1) {
      campaigns.value[campaignIndex].status = 'rejected'
      toastSuccess('Campaign rejected')
    }
    isDetailsModalOpen.value = false
  } catch (error) {
    toastError('Error rejecting campaign')
  }
}

// Pause campaign
const pauseCampaign = (campaign: Campaign) => {
  // In a real app, this would call the API
  try {
    const campaignIndex = campaigns.value.findIndex(c => c.id === campaign.id)
    if (campaignIndex !== -1) {
      campaigns.value[campaignIndex].status = 'paused'
      toastSuccess('Campaign paused')
    }
    isDetailsModalOpen.value = false
  } catch (error) {
    toastError('Error pausing campaign')
  }
}

// Activate campaign
const activateCampaign = (campaign: Campaign) => {
  // In a real app, this would call the API
  try {
    const campaignIndex = campaigns.value.findIndex(c => c.id === campaign.id)
    if (campaignIndex !== -1) {
      campaigns.value[campaignIndex].status = 'active'
      toastSuccess('Campaign activated')
    }
    isDetailsModalOpen.value = false
  } catch (error) {
    toastError('Error activating campaign')
  }
}
</script>

<template>
  <Head title="Campaign Management" />

  <AuthenticatedLayout>
    <template #header>
      <div class="px-4 sm:px-0">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Campaign Management
        </h2>
        <p class="mt-1 text-sm text-gray-600">Review and manage all advertiser campaigns</p>
      </div>
    </template>

    <div class="py-6 sm:py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Campaign Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-indigo-50 rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Active Campaigns</h3>
                <div class="mt-1 text-xl font-semibold text-gray-900">
                  {{ campaigns.filter(c => c.status === 'active').length }}
                </div>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-yellow-50 rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Pending Approval</h3>
                <div class="mt-1 text-xl font-semibold text-gray-900">
                  {{ campaigns.filter(c => c.status === 'pending').length }}
                </div>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-gray-50 rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Paused Campaigns</h3>
                <div class="mt-1 text-xl font-semibold text-gray-900">
                  {{ campaigns.filter(c => c.status === 'paused').length }}
                </div>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-green-50 rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Budget</h3>
                <div class="mt-1 text-xl font-semibold text-gray-900">
                  {{ formatCurrency(campaigns.reduce((sum, c) => sum + c.budget, 0)) }}
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 mb-6">
          <div class="p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between space-y-4 sm:space-y-0">
            <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
              <!-- Status filter -->
              <div>
                <label for="status-filter" class="sr-only">Filter by status</label>
                <select 
                  id="status-filter" 
                  v-model="filters.status"
                  class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                >
                  <option value="all">All Statuses</option>
                  <option value="active">Active</option>
                  <option value="pending">Pending</option>
                  <option value="paused">Paused</option>
                  <option value="rejected">Rejected</option>
                </select>
              </div>
              
              <!-- Category filter -->
              <div>
                <label for="category-filter" class="sr-only">Filter by category</label>
                <select 
                  id="category-filter" 
                  v-model="filters.category"
                  class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                >
                  <option v-for="category in categories" :key="category" :value="category">
                    {{ category === 'all' ? 'All Categories' : category }}
                  </option>
                </select>
              </div>
              
              <!-- Advertiser filter -->
              <div>
                <label for="advertiser-filter" class="sr-only">Filter by advertiser</label>
                <select 
                  id="advertiser-filter" 
                  v-model="filters.advertiser"
                  class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                >
                  <option v-for="advertiser in advertisers" :key="advertiser" :value="advertiser">
                    {{ advertiser === 'all' ? 'All Advertisers' : advertiser }}
                  </option>
                </select>
              </div>
            </div>
            
            <!-- Search -->
            <div class="relative w-full sm:w-64">
              <input
                v-model="filters.search"
                type="text"
                placeholder="Search campaigns..."
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
        
        <!-- Campaigns Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Advertiser</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Budget</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commission</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="campaign in filteredCampaigns" :key="campaign.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 h-10 w-10 rounded-md overflow-hidden bg-gray-100">
                        <img :src="campaign.image" :alt="campaign.name" class="h-10 w-10 object-cover" onerror="this.onerror=null; this.src='/img/campaigns/placeholder.jpg'" />
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ campaign.name }}</div>
                        <div class="text-xs text-gray-500">{{ campaign.category }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ campaign.advertiser }}</div>
                    <div class="text-xs text-gray-500">ID: {{ campaign.advertiser_id }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ formatCurrency(campaign.budget) }}</div>
                    <div class="text-xs text-gray-500">
                      Spent: {{ formatCurrency(campaign.total_spent) }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">
                      {{ formatCommission(campaign.commission_type, campaign.commission_value) }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full"
                          :class="{
                            'bg-green-100 text-green-800': campaign.status === 'active',
                            'bg-yellow-100 text-yellow-800': campaign.status === 'pending',
                            'bg-gray-100 text-gray-800': campaign.status === 'paused',
                            'bg-red-100 text-red-800': campaign.status === 'rejected'
                          }">
                      {{ campaign.status.charAt(0).toUpperCase() + campaign.status.slice(1) }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-xs text-gray-500">Start: {{ campaign.start_date }}</div>
                    <div class="text-xs text-gray-500">End: {{ campaign.end_date }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button 
                      @click="viewCampaignDetails(campaign)"
                      class="text-indigo-600 hover:text-indigo-900"
                    >
                      Details
                    </button>
                  </td>
                </tr>
                
                <!-- Empty state -->
                <tr v-if="filteredCampaigns.length === 0">
                  <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                    No campaigns found matching your search criteria.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Campaign Details Modal -->
    <div v-if="isDetailsModalOpen && selectedCampaign" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg shadow-xl overflow-hidden max-w-4xl w-full max-h-[90vh] flex flex-col">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
          <h3 class="text-lg font-medium text-gray-900">Campaign Details</h3>
          <button @click="isDetailsModalOpen = false" class="text-gray-400 hover:text-gray-500">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        
        <div class="p-6 overflow-y-auto">
          <div class="flex flex-col md:flex-row gap-6">
            <div class="md:w-1/3">
              <img :src="selectedCampaign.image" :alt="selectedCampaign.name" class="w-full rounded-md">
              
              <div class="mt-4 p-4 bg-gray-50 rounded-md">
                <h4 class="font-medium text-gray-900 mb-2">Campaign Details</h4>
                <div class="space-y-2">
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Advertiser:</span>
                    <span class="text-sm text-gray-900">{{ selectedCampaign.advertiser }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Category:</span>
                    <span class="text-sm text-gray-900">{{ selectedCampaign.category }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Budget:</span>
                    <span class="text-sm text-gray-900">{{ formatCurrency(selectedCampaign.budget) }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Commission:</span>
                    <span class="text-sm text-gray-900">{{ formatCommission(selectedCampaign.commission_type, selectedCampaign.commission_value) }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Status:</span>
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full"
                          :class="{
                            'bg-green-100 text-green-800': selectedCampaign.status === 'active',
                            'bg-yellow-100 text-yellow-800': selectedCampaign.status === 'pending',
                            'bg-gray-100 text-gray-800': selectedCampaign.status === 'paused',
                            'bg-red-100 text-red-800': selectedCampaign.status === 'rejected'
                          }">
                      {{ selectedCampaign.status.charAt(0).toUpperCase() + selectedCampaign.status.slice(1) }}
                    </span>
                  </div>
                </div>
              </div>
              
              <div class="mt-4 p-4 bg-gray-50 rounded-md">
                <h4 class="font-medium text-gray-900 mb-2">Performance</h4>
                <div class="space-y-2">
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Impressions:</span>
                    <span class="text-sm text-gray-900">{{ selectedCampaign.impressions.toLocaleString() }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Clicks:</span>
                    <span class="text-sm text-gray-900">{{ selectedCampaign.clicks.toLocaleString() }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Conversions:</span>
                    <span class="text-sm text-gray-900">{{ selectedCampaign.conversions.toLocaleString() }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Spent:</span>
                    <span class="text-sm text-gray-900">{{ formatCurrency(selectedCampaign.total_spent) }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-500">CTR:</span>
                    <span class="text-sm text-gray-900">{{ selectedCampaign.impressions ? ((selectedCampaign.clicks / selectedCampaign.impressions) * 100).toFixed(2) + '%' : 'N/A' }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Conversion Rate:</span>
                    <span class="text-sm text-gray-900">{{ selectedCampaign.clicks ? ((selectedCampaign.conversions / selectedCampaign.clicks) * 100).toFixed(2) + '%' : 'N/A' }}</span>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="md:w-2/3">
              <h4 class="font-medium text-gray-900 mb-2">Campaign Name</h4>
              <p class="text-gray-800 mb-4 text-lg font-semibold">{{ selectedCampaign.name }}</p>
              
              <h4 class="font-medium text-gray-900 mb-2">Description</h4>
              <p class="text-gray-600 mb-6">{{ selectedCampaign.description }}</p>
              
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div>
                  <h4 class="font-medium text-gray-900 mb-2">Start Date</h4>
                  <p class="text-gray-600">{{ selectedCampaign.start_date }}</p>
                </div>
                <div>
                  <h4 class="font-medium text-gray-900 mb-2">End Date</h4>
                  <p class="text-gray-600">{{ selectedCampaign.end_date }}</p>
                </div>
              </div>
              
              <h4 class="font-medium text-gray-900 mb-2">Administrator Notes</h4>
              <textarea
                placeholder="Add notes about this campaign (only visible to admins)..."
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                rows="4"
              ></textarea>
            </div>
          </div>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200 flex flex-wrap justify-end gap-2">
          <button 
            @click="isDetailsModalOpen = false" 
            class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md"
          >
            Close
          </button>
          
          <template v-if="selectedCampaign.status === 'pending'">
            <button 
              @click="rejectCampaign(selectedCampaign)" 
              class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md"
            >
              Reject
            </button>
            <button 
              @click="approveCampaign(selectedCampaign)" 
              class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md"
            >
              Approve
            </button>
          </template>
          
          <template v-else-if="selectedCampaign.status === 'active'">
            <button 
              @click="pauseCampaign(selectedCampaign)" 
              class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-md"
            >
              Pause Campaign
            </button>
          </template>
          
          <template v-else-if="selectedCampaign.status === 'paused'">
            <button 
              @click="activateCampaign(selectedCampaign)" 
              class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md"
            >
              Activate Campaign
            </button>
          </template>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template> 