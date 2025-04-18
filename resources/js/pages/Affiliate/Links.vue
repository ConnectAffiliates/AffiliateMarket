<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'
import { PageProps } from '@/types'
import { ref, computed } from 'vue'

const props = defineProps<{
  auth: PageProps['auth'],
  errors: {},
  referrals?: any[]
}>()

interface Referral {
  id: string;
  code: string;
  campaign: {
    id: string;
    name: string;
    image: string;
    advertiser: string;
  };
  clicks: number;
  conversions: number;
  conversion_rate: string;
  created_at: string;
  earnings: number;
  status: 'active' | 'paused' | 'expired';
}

// Sample data - in a real app, this would come from the backend
const referrals = ref<Referral[]>(props.referrals || [
  {
    id: '1',
    code: 'SUMMER24JD',
    campaign: {
      id: '1',
      name: 'Summer Fashion Sale',
      image: '/img/campaigns/fashion.jpg',
      advertiser: 'Fashion Store Inc.'
    },
    clicks: 342,
    conversions: 28,
    conversion_rate: '8.2%',
    created_at: '2024-03-15',
    earnings: 336000,
    status: 'active'
  },
  {
    id: '2',
    code: 'TECHGADGET',
    campaign: {
      id: '2',
      name: 'Smartphone Launch',
      image: '/img/campaigns/tech.jpg',
      advertiser: 'TechGadgets'
    },
    clicks: 523,
    conversions: 42,
    conversion_rate: '8.0%',
    created_at: '2024-03-10',
    earnings: 294000,
    status: 'active'
  },
  {
    id: '3',
    code: 'FITLIFE25',
    campaign: {
      id: '3',
      name: 'Home Fitness Equipment',
      image: '/img/campaigns/fitness.jpg',
      advertiser: 'FitLife Store'
    },
    clicks: 265,
    conversions: 19,
    conversion_rate: '7.2%',
    created_at: '2024-02-22',
    earnings: 475000,
    status: 'active'
  },
  {
    id: '4',
    code: 'LEARN15OFF',
    campaign: {
      id: '4',
      name: 'Online Course Bundle',
      image: '/img/campaigns/education.jpg',
      advertiser: 'LearnMore Academy'
    },
    clicks: 189,
    conversions: 15,
    conversion_rate: '7.9%',
    created_at: '2024-02-18',
    earnings: 202500,
    status: 'paused'
  }
])

// Active campaign links for creating new referral links
const activeCampaigns = ref([
  { id: '1', name: 'Summer Fashion Sale', advertiser: 'Fashion Store Inc.' },
  { id: '2', name: 'Smartphone Launch', advertiser: 'TechGadgets' },
  { id: '3', name: 'Home Fitness Equipment', advertiser: 'FitLife Store' },
  { id: '4', name: 'Online Course Bundle', advertiser: 'LearnMore Academy' },
  { id: '5', name: 'Travel Package Deals', advertiser: 'Wanderlust Travels' },
  { id: '6', name: 'Organic Skincare Products', advertiser: 'Pure Beauty Co.' }
])

const searchQuery = ref('')
const statusFilter = ref('all')
const isCreatingLink = ref(false)
const newLinkForm = ref({
  campaignId: '',
  customCode: '',
  showCustomCode: false
})

// Filter referrals
const filteredReferrals = computed(() => {
  let result = referrals.value
  
  // Filter by status
  if (statusFilter.value !== 'all') {
    result = result.filter(referral => referral.status === statusFilter.value)
  }
  
  // Filter by search query
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    result = result.filter(referral => 
      referral.code.toLowerCase().includes(query) || 
      referral.campaign.name.toLowerCase().includes(query) ||
      referral.campaign.advertiser.toLowerCase().includes(query)
    )
  }
  
  return result
})

// Format currency
const formatCurrency = (amount: number): string => {
  return `TZS ${amount.toLocaleString()}`
}

// Copy link to clipboard
const copyLinkToClipboard = (code: string): void => {
  const baseUrl = 'https://example.com/ref/'
  const fullLink = `${baseUrl}${code}`
  
  navigator.clipboard.writeText(fullLink)
    .then(() => {
      alert('Link copied to clipboard!')
    })
    .catch(err => {
      console.error('Could not copy text: ', err)
    })
}

// Toggle link status
const toggleLinkStatus = (id: string): void => {
  const referral = referrals.value.find(r => r.id === id)
  if (referral) {
    referral.status = referral.status === 'active' ? 'paused' : 'active'
  }
}

// Create new referral link
const createNewLink = (): void => {
  if (!newLinkForm.value.campaignId) {
    alert('Please select a campaign')
    return
  }
  
  const campaign = activeCampaigns.value.find(c => c.id === newLinkForm.value.campaignId)
  if (!campaign) return
  
  // Generate a code if not provided
  const code = newLinkForm.value.customCode || 
    `${campaign.name.slice(0, 4).toUpperCase()}${Math.floor(Math.random() * 1000)}`
  
  // Create new referral
  const newReferral: Referral = {
    id: `new-${Date.now()}`,
    code: code.replace(/\s+/g, ''),
    campaign: {
      id: campaign.id,
      name: campaign.name,
      image: `/img/campaigns/placeholder.jpg`,
      advertiser: campaign.advertiser
    },
    clicks: 0,
    conversions: 0,
    conversion_rate: '0%',
    created_at: new Date().toISOString().split('T')[0],
    earnings: 0,
    status: 'active'
  }
  
  // Add to the list
  referrals.value.unshift(newReferral)
  
  // Reset form
  newLinkForm.value = {
    campaignId: '',
    customCode: '',
    showCustomCode: false
  }
  
  isCreatingLink.value = false
}

// Format date
const formatDate = (dateString: string): string => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}
</script>

<template>
  <Head title="My Referral Links" />

  <AuthenticatedLayout>
    <template #header>
      <div class="px-4 sm:px-0">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          My Referral Links
        </h2>
        <p class="mt-1 text-sm text-gray-600">Create and manage your promotional links</p>
      </div>
    </template>

    <div class="py-6 sm:py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Controls -->
        <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between space-y-4 sm:space-y-0">
          <div class="flex space-x-2">
            <button 
              @click="statusFilter = 'all'" 
              class="px-3 py-1 text-sm font-medium rounded-md"
              :class="statusFilter === 'all' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
            >
              All Links
            </button>
            <button 
              @click="statusFilter = 'active'" 
              class="px-3 py-1 text-sm font-medium rounded-md"
              :class="statusFilter === 'active' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200'"
            >
              Active
            </button>
            <button 
              @click="statusFilter = 'paused'" 
              class="px-3 py-1 text-sm font-medium rounded-md"
              :class="statusFilter === 'paused' ? 'bg-yellow-600 text-white' : 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200'"
            >
              Paused
            </button>
          </div>
          <div class="flex space-x-3 w-full sm:w-auto">
            <div class="relative flex-grow sm:flex-grow-0">
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search links..."
                class="w-full sm:w-64 pr-10 pl-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              />
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
            
            <button 
              @click="isCreatingLink = true"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Create New Link
            </button>
          </div>
        </div>
        
        <!-- Create New Link Form -->
        <div v-if="isCreatingLink" class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 mb-6">
          <div class="p-4 sm:p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
              <h3 class="text-base font-semibold text-gray-900">Create New Referral Link</h3>
              <button @click="isCreatingLink = false" class="text-gray-400 hover:text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
          
          <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 gap-4">
              <div>
                <label for="campaign" class="block text-sm font-medium text-gray-700">Select Campaign</label>
                <select 
                  id="campaign" 
                  v-model="newLinkForm.campaignId" 
                  class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                >
                  <option value="">Select a campaign</option>
                  <option v-for="campaign in activeCampaigns" :key="campaign.id" :value="campaign.id">
                    {{ campaign.name }} ({{ campaign.advertiser }})
                  </option>
                </select>
              </div>
              
              <div>
                <div class="flex items-center">
                  <input 
                    id="custom-code" 
                    v-model="newLinkForm.showCustomCode" 
                    type="checkbox" 
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" 
                  />
                  <label for="custom-code" class="ml-2 block text-sm text-gray-900">
                    Use custom referral code
                  </label>
                </div>
                
                <div v-if="newLinkForm.showCustomCode" class="mt-3">
                  <label for="code" class="block text-sm font-medium text-gray-700">Custom Code</label>
                  <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                      ref/
                    </span>
                    <input 
                      type="text" 
                      id="code" 
                      v-model="newLinkForm.customCode" 
                      class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300" 
                      placeholder="SUMMER2024"
                    />
                  </div>
                  <p class="mt-1 text-sm text-gray-500">
                    Letters, numbers, and underscores only. No spaces.
                  </p>
                </div>
              </div>
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
              <button 
                @click="isCreatingLink = false"
                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                Cancel
              </button>
              <button 
                @click="createNewLink"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                Create Link
              </button>
            </div>
          </div>
        </div>
        
        <!-- Links Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referral Code</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clicks</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conversions</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Earnings</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-if="filteredReferrals.length === 0">
                  <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                    No referral links found. Create your first link to start earning!
                  </td>
                </tr>
                
                <tr v-for="referral in filteredReferrals" :key="referral.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 h-10 w-10 rounded overflow-hidden bg-gray-100">
                        <img :src="referral.campaign.image" :alt="referral.campaign.name" class="h-10 w-10 object-cover" onerror="this.onerror=null; this.src='/img/campaigns/placeholder.jpg'" />
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ referral.campaign.name }}</div>
                        <div class="text-sm text-gray-500">{{ referral.campaign.advertiser }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center text-sm">
                      <span class="font-medium text-indigo-600">{{ referral.code }}</span>
                      <button 
                        @click="copyLinkToClipboard(referral.code)"
                        class="ml-2 text-gray-400 hover:text-gray-600"
                        title="Copy link to clipboard"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                      </button>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ referral.clicks.toLocaleString() }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ referral.conversions }}</div>
                    <div class="text-xs text-gray-500">{{ referral.conversion_rate }} CR</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-emerald-600">
                    {{ formatCurrency(referral.earnings) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span 
                      class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
                      :class="{
                        'bg-green-100 text-green-800': referral.status === 'active',
                        'bg-yellow-100 text-yellow-800': referral.status === 'paused',
                        'bg-red-100 text-red-800': referral.status === 'expired'
                      }"
                    >
                      {{ referral.status.charAt(0).toUpperCase() + referral.status.slice(1) }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ formatDate(referral.created_at) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end space-x-3">
                      <button 
                        @click="toggleLinkStatus(referral.id)"
                        :title="referral.status === 'active' ? 'Pause link' : 'Activate link'"
                        class="text-gray-400 hover:text-gray-600"
                      >
                        <svg v-if="referral.status === 'active'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                      </button>
                      <a 
                        :href="`/affiliate/stats?ref=${referral.code}`"
                        title="View detailed analytics"
                        class="text-indigo-600 hover:text-indigo-900"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
        <!-- Marketing Tips -->
        <div class="mt-8 bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
          <div class="p-4 sm:p-6 border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-900">Affiliate Marketing Tips</h3>
          </div>
          
          <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="bg-indigo-50 rounded-lg p-4">
                <div class="flex items-center">
                  <div class="flex-shrink-0 bg-indigo-100 rounded-full p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                    </svg>
                  </div>
                  <h4 class="ml-3 text-sm font-medium text-indigo-900">Use Unique Links</h4>
                </div>
                <p class="mt-2 text-sm text-indigo-800">
                  Create different tracking links for each platform to measure which channels perform best.
                </p>
              </div>
              
              <div class="bg-green-50 rounded-lg p-4">
                <div class="flex items-center">
                  <div class="flex-shrink-0 bg-green-100 rounded-full p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                  </div>
                  <h4 class="ml-3 text-sm font-medium text-green-900">Promote Strategically</h4>
                </div>
                <p class="mt-2 text-sm text-green-800">
                  Focus on products and services that align with your audience's interests and needs.
                </p>
              </div>
              
              <div class="bg-amber-50 rounded-lg p-4">
                <div class="flex items-center">
                  <div class="flex-shrink-0 bg-amber-100 rounded-full p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                  </div>
                  <h4 class="ml-3 text-sm font-medium text-amber-900">Build Trust</h4>
                </div>
                <p class="mt-2 text-sm text-amber-800">
                  Only promote products you believe in. Honest recommendations build long-term credibility.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template> 