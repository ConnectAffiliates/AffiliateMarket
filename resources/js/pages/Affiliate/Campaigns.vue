<script setup lang="ts">
import { ref, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'
import { toastSuccess } from '@/utils/toast'
import type { User } from '@/types'

const props = defineProps<{
  auth: {
    user: User;
  },
  errors: Record<string, string>,
  campaigns?: any[]
}>()

// Sample data - this would come from the backend in a real app
const allCampaigns = ref(props.campaigns || [
  { 
    id: 1, 
    name: 'Summer Fashion Sale', 
    advertiser: 'Fashion Store Inc.', 
    description: 'Promote our summer fashion collection with exclusive discounts for your audience.',
    commission_type: 'fixed',
    commission_value: 12,
    category: 'Fashion',
    status: 'active',
    conversion_rate: '6.3%',
    earnings_potential: 'TZS 15,000 - 25,000 daily',
    image: '/img/campaigns/fashion.jpg',
    is_joined: false
  },
  { 
    id: 2, 
    name: 'Smartphone Launch', 
    advertiser: 'TechGadgets', 
    description: 'Be among the first to promote our new smartphone model with competitive commissions.',
    commission_type: 'percentage',
    commission_value: 8,
    category: 'Electronics',
    status: 'active',
    conversion_rate: '4.7%',
    earnings_potential: 'TZS 18,000 - 30,000 daily',
    image: '/img/campaigns/tech.jpg',
    is_joined: true
  },
  { 
    id: 3, 
    name: 'Home Fitness Equipment', 
    advertiser: 'FitLife Store', 
    description: 'Help your audience stay fit at home with our premium exercise equipment.',
    commission_type: 'fixed',
    commission_value: 25,
    category: 'Fitness',
    status: 'active',
    conversion_rate: '5.2%',
    earnings_potential: 'TZS 20,000 - 35,000 daily',
    image: '/img/campaigns/fitness.jpg',
    is_joined: false
  },
  { 
    id: 4, 
    name: 'Online Course Bundle', 
    advertiser: 'LearnMore Academy', 
    description: 'Promote our educational courses and help your audience gain valuable skills.',
    commission_type: 'percentage',
    commission_value: 15,
    category: 'Education',
    status: 'active',
    conversion_rate: '7.8%',
    earnings_potential: 'TZS 12,000 - 22,000 daily',
    image: '/img/campaigns/education.jpg',
    is_joined: false
  },
  { 
    id: 5, 
    name: 'Travel Package Deals', 
    advertiser: 'Wanderlust Travels', 
    description: 'Exotic travel packages at exclusive rates for your audience with high commission.',
    commission_type: 'percentage',
    commission_value: 10,
    category: 'Travel',
    status: 'active',
    conversion_rate: '4.1%',
    earnings_potential: 'TZS 25,000 - 40,000 daily',
    image: '/img/campaigns/travel.jpg',
    is_joined: false
  },
  { 
    id: 6, 
    name: 'Organic Skincare Products', 
    advertiser: 'Pure Beauty Co.', 
    description: 'Natural and sustainable skincare products with great affiliate commissions.',
    commission_type: 'fixed',
    commission_value: 15,
    category: 'Beauty',
    status: 'active',
    conversion_rate: '6.9%',
    earnings_potential: 'TZS 14,000 - 24,000 daily',
    image: '/img/campaigns/beauty.jpg',
    is_joined: false
  }
])

const searchQuery = ref('')
const selectedCategory = ref('all')
const sortBy = ref('earnings_potential')

// Categories
const categories = computed(() => {
  const cats = ['all']
  allCampaigns.value.forEach(campaign => {
    if (!cats.includes(campaign.category.toLowerCase())) {
      cats.push(campaign.category.toLowerCase())
    }
  })
  return cats
})

// Filtered campaigns
const filteredCampaigns = computed(() => {
  let result = allCampaigns.value
  
  // Filter by category
  if (selectedCategory.value !== 'all') {
    result = result.filter(campaign => 
      campaign.category.toLowerCase() === selectedCategory.value.toLowerCase()
    )
  }
  
  // Filter by search query
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    result = result.filter(campaign => 
      campaign.name.toLowerCase().includes(query) || 
      campaign.advertiser.toLowerCase().includes(query) ||
      campaign.description.toLowerCase().includes(query)
    )
  }
  
  // Sort
  if (sortBy.value === 'earnings_potential') {
    result = [...result].sort((a, b) => {
      // Simple sort based on extraction of first number in the earnings potential string
      const aValue = parseInt(a.earnings_potential.replace(/[^0-9]/g, ''))
      const bValue = parseInt(b.earnings_potential.replace(/[^0-9]/g, ''))
      return bValue - aValue
    })
  } else if (sortBy.value === 'conversion_rate') {
    result = [...result].sort((a, b) => {
      const aRate = parseFloat(a.conversion_rate.replace('%', ''))
      const bRate = parseFloat(b.conversion_rate.replace('%', ''))
      return bRate - aRate
    })
  } else if (sortBy.value === 'commission') {
    result = [...result].sort((a, b) => {
      // Fixed value comparison is straightforward
      if (a.commission_type === 'fixed' && b.commission_type === 'fixed') {
        return b.commission_value - a.commission_value
      }
      // Percentage comparison is straightforward
      else if (a.commission_type === 'percentage' && b.commission_type === 'percentage') {
        return b.commission_value - a.commission_value
      }
      // Mixed comparison is more complex, we'll prioritize percentage for simplicity
      else if (a.commission_type === 'percentage') {
        return -1
      } else {
        return 1
      }
    })
  }
  
  return result
})

interface Campaign {
  id: number;
  name: string;
  advertiser: string;
  description: string;
  commission_type: 'fixed' | 'percentage';
  commission_value: number;
  category: string;
  status: string;
  conversion_rate: string;
  earnings_potential: string;
  image: string;
  is_joined: boolean;
}

const formatCommission = (campaign: Campaign | null) => {
  if (!campaign) return '';
  
  if (campaign.commission_type === 'fixed') {
    return `TZS ${campaign.commission_value.toLocaleString()} per sale`
  } else {
    return `${campaign.commission_value}% of sale`
  }
}

const joinCampaign = (campaignId: number | undefined) => {
  if (!campaignId) return;
  
  // In a real app, this would make an API call to join the campaign
  const campaign = allCampaigns.value.find(c => c.id === campaignId)
  if (campaign) {
    campaign.is_joined = true
    toastSuccess('Successfully joined campaign!')
  }
}

const leaveCampaign = (campaignId: number | undefined) => {
  if (!campaignId) return;
  
  // In a real app, this would make an API call to leave the campaign
  const campaign = allCampaigns.value.find(c => c.id === campaignId)
  if (campaign) {
    campaign.is_joined = false
    toastSuccess('Successfully left campaign')
  }
}

// View details of a campaign
const selectedCampaign = ref<Campaign | null>(null)
const viewCampaignDetails = (campaign: Campaign) => {
  selectedCampaign.value = campaign
}
</script>

<template>
  <Head title="Available Campaigns" />

  <AuthenticatedLayout>
    <template #header>
      <div class="px-4 sm:px-0">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Available Campaigns
        </h2>
        <p class="mt-1 text-sm text-gray-600">Discover and join high-converting offers</p>
      </div>
    </template>

    <div class="py-6 sm:py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 mb-6">
          <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between space-y-4 sm:space-y-0">
            <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
              <!-- Categories -->
              <div class="inline-flex flex-wrap gap-2">
                <button 
                  v-for="category in categories" 
                  :key="category"
                  @click="selectedCategory = category"
                  class="px-3 py-1 text-sm font-medium rounded-full"
                  :class="selectedCategory === category ? 
                    'bg-indigo-600 text-white' : 
                    'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                >
                  {{ category.charAt(0).toUpperCase() + category.slice(1) }}
                </button>
              </div>
              
              <!-- Sort options -->
              <div class="flex items-center space-x-2">
                <label for="sortBy" class="text-sm text-gray-700">Sort by:</label>
                <select 
                  id="sortBy" 
                  v-model="sortBy"
                  class="text-sm border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500"
                >
                  <option value="earnings_potential">Earnings Potential</option>
                  <option value="conversion_rate">Conversion Rate</option>
                  <option value="commission">Commission</option>
                </select>
              </div>
            </div>
            
            <!-- Search -->
            <div class="relative w-full sm:w-64">
              <input
                v-model="searchQuery"
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
        
        <!-- Campaign Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="campaign in filteredCampaigns" :key="campaign.id" class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="aspect-w-16 aspect-h-9 bg-gray-200">
              <img :src="campaign.image" :alt="campaign.name" class="w-full h-48 object-cover" onerror="this.onerror=null; this.src='/img/campaigns/placeholder.jpg'" />
              
              <div class="absolute top-0 right-0 m-4">
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                  {{ campaign.category }}
                </span>
              </div>
            </div>
            
            <div class="p-6">
              <div class="flex items-start justify-between">
                <div>
                  <h3 class="text-lg font-medium text-gray-900">{{ campaign.name }}</h3>
                  <p class="mt-1 text-sm text-gray-500">{{ campaign.advertiser }}</p>
                </div>
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                  {{ formatCommission(campaign) }}
                </span>
              </div>
              
              <p class="mt-3 text-sm text-gray-600">{{ campaign.description }}</p>
              
              <div class="mt-4 grid grid-cols-2 gap-4">
                <div>
                  <span class="block text-xs text-gray-500">Conversion Rate</span>
                  <span class="text-sm font-medium text-gray-900">{{ campaign.conversion_rate }}</span>
                </div>
                <div>
                  <span class="block text-xs text-gray-500">Earnings Potential</span>
                  <span class="text-sm font-medium text-emerald-600">{{ campaign.earnings_potential }}</span>
                </div>
              </div>
              
              <div class="mt-6">
                <button 
                  v-if="!campaign.is_joined" 
                  @click="viewCampaignDetails(campaign)"
                  class="w-full flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                  View Details
                </button>
                <div v-else class="flex space-x-3">
                  <button class="flex-1 flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Get Links
                  </button>
                  <button class="flex-1 flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Analytics
                  </button>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Empty state -->
          <div v-if="filteredCampaigns.length === 0" class="col-span-full py-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No campaigns found</h3>
            <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filters to find what you're looking for.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Campaign Details Modal -->
    <div v-if="selectedCampaign" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg shadow-xl overflow-hidden max-w-4xl w-full max-h-[90vh] flex flex-col">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
          <h3 class="text-lg font-medium text-gray-900">{{ selectedCampaign.name }}</h3>
          <button @click="selectedCampaign = null" class="text-gray-400 hover:text-gray-500">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        
        <div class="p-6 overflow-y-auto">
          <div class="flex flex-col md:flex-row gap-6">
            <div class="md:w-1/3">
              <img :src="selectedCampaign?.image" :alt="selectedCampaign?.name" class="w-full rounded-md">
              
              <div class="mt-4 p-4 bg-gray-50 rounded-md">
                <h4 class="font-medium text-gray-900 mb-2">Campaign Details</h4>
                <div class="space-y-2">
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Advertiser:</span>
                    <span class="text-sm text-gray-900">{{ selectedCampaign?.advertiser }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Category:</span>
                    <span class="text-sm text-gray-900">{{ selectedCampaign?.category }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Commission:</span>
                    <span class="text-sm text-gray-900">{{ formatCommission(selectedCampaign) }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Earnings Potential:</span>
                    <span class="text-sm text-gray-900">{{ selectedCampaign?.earnings_potential }}</span>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="md:w-2/3">
              <h4 class="font-medium text-gray-900 mb-2">Description</h4>
              <p class="text-gray-600 mb-6">{{ selectedCampaign?.description }}</p>
              
              <h4 class="font-medium text-gray-900 mb-2">Requirements</h4>
              <p class="text-gray-600 mb-6">
                This campaign offers {{ formatCommission(selectedCampaign) }} for each successful conversion.
                <span v-if="selectedCampaign?.commission_type === 'percentage'">
                  This is calculated as {{ selectedCampaign?.commission_value }}% of the product's value.
                </span>
                <span v-else>
                  This is a fixed commission of {{ selectedCampaign?.commission_value }} per sale of the product.
                </span>
              </p>
              
              <h4 class="font-medium text-gray-900 mb-2">Payment Terms</h4>
              <p class="text-gray-600 mb-6">
                Cookie duration: 45 days<br>
                Payment frequency: Monthly<br>
                Payment methods: Bank transfer, PayPal
              </p>
              
              <h4 class="font-medium text-gray-900 mb-2">Marketing Materials</h4>
              <p class="text-gray-600 mb-4">
                This campaign includes promotional banners and pre-written email templates.
                Once you join the campaign, you'll have access to all marketing materials through your affiliate dashboard.
              </p>
            </div>
          </div>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
          <button 
            @click="selectedCampaign = null" 
            class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md mr-2"
          >
            Cancel
          </button>
          <button 
            v-if="!selectedCampaign?.is_joined"
            @click="joinCampaign(selectedCampaign?.id)" 
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md"
          >
            Join Campaign
          </button>
          <button 
            v-else
            @click="leaveCampaign(selectedCampaign?.id)" 
            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md"
          >
            Leave Campaign
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>