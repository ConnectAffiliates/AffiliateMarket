<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdvertiserLayout from '@/layouts/AdvertiserLayout.vue'
import { PageProps } from '@/types'
import { ref, computed, watch } from 'vue'

defineProps<{
  auth: PageProps['auth'],
  errors: {}
}>()

const campaignTypes = [
  { id: 'physical', name: 'Physical Store Campaign', description: 'For brick and mortar shops where customers visit in person' },
  { id: 'online', name: 'Online Store Campaign', description: 'For e-commerce websites where customers purchase online' },
  { id: 'hybrid', name: 'Hybrid Campaign', description: 'For businesses with both physical and online presence' }
]

const commissionTypes = [
  { id: 'fixed', name: 'Fixed Amount', description: 'Pay a flat fee per successful referral' },
  { id: 'percentage', name: 'Percentage of Sale', description: 'Pay a percentage of the sale value' },
  { id: 'tiered', name: 'Tiered Commission', description: 'Pay different amounts based on sales value' }
]

const verificationMethods = [
  { id: 'code', name: 'Referral Code', description: 'Customer shows a unique code at checkout' },
  { id: 'qr', name: 'QR Code Scan', description: 'Scan a QR code from customer\'s phone' },
  { id: 'sms', name: 'SMS Verification', description: 'Customer shows a confirmation SMS' },
  { id: 'link', name: 'Tracking Link', description: 'Customer clicks on a unique tracking link (online only)' }
]

const form = useForm({
  name: '',
  description: '',
  campaign_type: 'hybrid',
  start_date: '',
  end_date: '',
  budget: '',
  commission_type: 'fixed',
  commission_value: '',
  verification_method: 'code',
  terms_conditions: '',
  store_address: '',
  website_url: '',
  product_categories: [] as string[],
  target_audience: [] as string[],
  banner_image: null as File | null
})

const selectedCampaignType = ref('hybrid')
const selectedCommissionType = ref('fixed')
const selectedVerificationMethod = ref('code')

const tieredCommissions = ref([
  { min_value: '0', max_value: '50000', commission: '1000' },
  { min_value: '50001', max_value: '200000', commission: '2500' },
  { min_value: '200001', max_value: '', commission: '5000' }
])

const addTierRow = () => {
  tieredCommissions.value.push({ min_value: '', max_value: '', commission: '' })
}

const removeTierRow = (index: number) => {
  tieredCommissions.value.splice(index, 1)
}

const categories = ref([
  'Fashion & Clothing',
  'Electronics',
  'Home & Furniture',
  'Beauty & Health',
  'Food & Groceries',
  'Services',
  'Entertainment',
  'Travel',
  'Education',
  'Other'
])

const audiences = ref([
  'Youth',
  'Professionals',
  'Parents',
  'Students',
  'Business Owners',
  'Seniors',
  'Tourists'
])

const handleSubmit = () => {
  if (selectedCommissionType.value === 'tiered') {
    form.commission_value = JSON.stringify(tieredCommissions.value)
  }
  
  form.campaign_type = selectedCampaignType.value
  form.commission_type = selectedCommissionType.value
  form.verification_method = selectedVerificationMethod.value
  
  form.post(route('advertiser.campaigns.store'), {
    preserveScroll: true,
    onSuccess: () => {
      // Success alert or redirect can be added here
    }
  })
}

const campaignTypeNeeds = computed(() => {
  return {
    needsStoreAddress: ['physical', 'hybrid'].includes(selectedCampaignType.value),
    needsWebsiteUrl: ['online', 'hybrid'].includes(selectedCampaignType.value)
  }
})

const handleImageUpload = (event: Event) => {
  const file = (event.target as HTMLInputElement).files?.[0]
  if (file) {
    form.banner_image = file
  }
}

// Show appropriate verification methods based on campaign type
const availableVerificationMethods = computed(() => {
  if (selectedCampaignType.value === 'online') {
    return verificationMethods
  } else if (selectedCampaignType.value === 'physical') {
    return verificationMethods.filter(method => method.id !== 'link')
  } else {
    return verificationMethods
  }
})

// Reset verification method if not available for selected campaign type
watch(selectedCampaignType, (newType) => {
  if (newType === 'physical' && selectedVerificationMethod.value === 'link') {
    selectedVerificationMethod.value = 'code'
  }
})
</script>

<template>
  <Head title="Create Campaign" />

  <AdvertiserLayout>
    <template #header>
      <div class="px-4 sm:px-0">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Create New Campaign
        </h2>
        <p class="mt-1 text-sm text-gray-600">Set up a marketing campaign for affiliates to promote</p>
      </div>
    </template>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
      <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Campaign Details</h3>
        <p class="mt-1 text-sm text-gray-600">Create a campaign for affiliates to promote your products or services</p>
      </div>

      <form @submit.prevent="handleSubmit" class="p-6 space-y-6">
        <!-- Basic Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Campaign Name</label>
            <input 
              type="text" 
              id="name" 
              v-model="form.name" 
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
              placeholder="E.g. Summer Sale 2023"
            />
            <div v-if="form.errors.name" class="text-sm text-red-600 mt-1">{{ form.errors.name }}</div>
          </div>

          <div>
            <label for="budget" class="block text-sm font-medium text-gray-700">Budget (TZS)</label>
            <input 
              type="number" 
              id="budget" 
              v-model="form.budget" 
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
              placeholder="Total campaign budget in TZS"
            />
            <div v-if="form.errors.budget" class="text-sm text-red-600 mt-1">{{ form.errors.budget }}</div>
          </div>
        </div>

        <div>
          <label for="description" class="block text-sm font-medium text-gray-700">Campaign Description</label>
          <textarea 
            id="description" 
            v-model="form.description" 
            rows="3" 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Describe what you're promoting and what makes it appealing"
          ></textarea>
          <div v-if="form.errors.description" class="text-sm text-red-600 mt-1">{{ form.errors.description }}</div>
        </div>

        <!-- Campaign Type Selection -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Campaign Type</label>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div 
              v-for="type in campaignTypes" 
              :key="type.id"
              @click="selectedCampaignType = type.id"
              class="border rounded-lg p-4 cursor-pointer"
              :class="{'border-indigo-500 bg-indigo-50': selectedCampaignType === type.id, 'border-gray-200': selectedCampaignType !== type.id}"
            >
              <div class="flex items-center">
                <input 
                  type="radio" 
                  :id="type.id" 
                  :value="type.id" 
                  v-model="selectedCampaignType"
                  class="h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                />
                <label :for="type.id" class="ml-3 block text-sm font-medium text-gray-700">{{ type.name }}</label>
              </div>
              <p class="mt-1 text-xs text-gray-500 ml-7">{{ type.description }}</p>
            </div>
          </div>
          <div v-if="form.errors.campaign_type" class="text-sm text-red-600 mt-1">{{ form.errors.campaign_type }}</div>
        </div>

        <!-- Campaign Dates -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
            <input 
              type="date" 
              id="start_date" 
              v-model="form.start_date" 
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            />
            <div v-if="form.errors.start_date" class="text-sm text-red-600 mt-1">{{ form.errors.start_date }}</div>
          </div>

          <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
            <input 
              type="date" 
              id="end_date" 
              v-model="form.end_date" 
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            />
            <div v-if="form.errors.end_date" class="text-sm text-red-600 mt-1">{{ form.errors.end_date }}</div>
          </div>
        </div>

        <!-- Location Information (conditional) -->
        <div v-if="campaignTypeNeeds.needsStoreAddress">
          <label for="store_address" class="block text-sm font-medium text-gray-700">Store Address</label>
          <textarea 
            id="store_address" 
            v-model="form.store_address" 
            rows="2" 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Physical location where customers can visit"
          ></textarea>
          <div v-if="form.errors.store_address" class="text-sm text-red-600 mt-1">{{ form.errors.store_address }}</div>
        </div>

        <div v-if="campaignTypeNeeds.needsWebsiteUrl">
          <label for="website_url" class="block text-sm font-medium text-gray-700">Website URL</label>
          <input 
            type="url" 
            id="website_url" 
            v-model="form.website_url" 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="https://yourwebsite.com"
          />
          <div v-if="form.errors.website_url" class="text-sm text-red-600 mt-1">{{ form.errors.website_url }}</div>
        </div>

        <!-- Commission Structure -->
        <div>
          <h4 class="text-base font-medium text-gray-900 mb-2">Commission Structure</h4>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div 
              v-for="type in commissionTypes" 
              :key="type.id"
              @click="selectedCommissionType = type.id"
              class="border rounded-lg p-4 cursor-pointer"
              :class="{'border-indigo-500 bg-indigo-50': selectedCommissionType === type.id, 'border-gray-200': selectedCommissionType !== type.id}"
            >
              <div class="flex items-center">
                <input 
                  type="radio" 
                  :id="'commission_'+type.id" 
                  :value="type.id" 
                  v-model="selectedCommissionType"
                  class="h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                />
                <label :for="'commission_'+type.id" class="ml-3 block text-sm font-medium text-gray-700">{{ type.name }}</label>
              </div>
              <p class="mt-1 text-xs text-gray-500 ml-7">{{ type.description }}</p>
            </div>
          </div>

          <!-- Fixed Commission Amount -->
          <div v-if="selectedCommissionType === 'fixed'" class="mt-4">
            <label for="commission_value" class="block text-sm font-medium text-gray-700">Commission Amount (TZS)</label>
            <input 
              type="number" 
              id="commission_value" 
              v-model="form.commission_value" 
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
              placeholder="e.g. 5000"
            />
            <p class="mt-1 text-xs text-gray-500">Amount in TZS paid per successful referral</p>
          </div>

          <!-- Percentage Commission -->
          <div v-if="selectedCommissionType === 'percentage'" class="mt-4">
            <label for="commission_value" class="block text-sm font-medium text-gray-700">Commission Percentage (%)</label>
            <div class="mt-1 relative rounded-md shadow-sm">
              <input 
                type="number" 
                id="commission_value" 
                v-model="form.commission_value" 
                class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 pr-12"
                placeholder="e.g. 10"
                step="0.1"
                min="0"
                max="100"
              />
              <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                <span class="text-gray-500 sm:text-sm">%</span>
              </div>
            </div>
            <p class="mt-1 text-xs text-gray-500">Percentage of sale value paid to affiliate</p>
          </div>

          <!-- Tiered Commission -->
          <div v-if="selectedCommissionType === 'tiered'" class="mt-4">
            <div class="flex justify-between items-center mb-2">
              <label class="block text-sm font-medium text-gray-700">Tiered Commission Rates</label>
              <button 
                type="button" 
                @click="addTierRow"
                class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                Add Tier
              </button>
            </div>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Minimum (TZS)
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Maximum (TZS)
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Commission (TZS)
                    </th>
                    <th scope="col" class="relative px-4 py-3 w-10">
                      <span class="sr-only">Actions</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="(tier, index) in tieredCommissions" :key="index">
                    <td class="px-4 py-2">
                      <input 
                        type="number" 
                        v-model="tier.min_value" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                        placeholder="0"
                      />
                    </td>
                    <td class="px-4 py-2">
                      <input 
                        type="number" 
                        v-model="tier.max_value" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                        placeholder="No limit"
                      />
                    </td>
                    <td class="px-4 py-2">
                      <input 
                        type="number" 
                        v-model="tier.commission" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                        placeholder="Commission amount"
                      />
                    </td>
                    <td class="px-4 py-2 text-center">
                      <button 
                        v-if="tieredCommissions.length > 1"
                        type="button" 
                        @click="removeTierRow(index)"
                        class="text-red-600 hover:text-red-900"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p class="mt-2 text-xs text-gray-500">Define different commission rates based on sale value</p>
          </div>
        </div>

        <!-- Verification Method -->
        <div>
          <h4 class="text-base font-medium text-gray-900 mb-2">Verification Method</h4>
          <p class="text-sm text-gray-600 mb-3">How will you verify that a customer came from an affiliate?</p>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div 
              v-for="method in availableVerificationMethods" 
              :key="method.id"
              @click="selectedVerificationMethod = method.id"
              class="border rounded-lg p-4 cursor-pointer"
              :class="{'border-indigo-500 bg-indigo-50': selectedVerificationMethod === method.id, 'border-gray-200': selectedVerificationMethod !== method.id}"
            >
              <div class="flex items-center">
                <input 
                  type="radio" 
                  :id="'verification_'+method.id" 
                  :value="method.id" 
                  v-model="selectedVerificationMethod"
                  class="h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                />
                <label :for="'verification_'+method.id" class="ml-3 block text-sm font-medium text-gray-700">{{ method.name }}</label>
              </div>
              <p class="mt-1 text-xs text-gray-500 ml-7">{{ method.description }}</p>
            </div>
          </div>
        </div>

        <!-- Campaign Categories -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Product Categories</label>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
            <div v-for="category in categories" :key="category" class="flex items-center">
              <input 
                type="checkbox" 
                :id="'category_' + category" 
                :value="category" 
                v-model="form.product_categories"
                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
              />
              <label :for="'category_' + category" class="ml-2 block text-sm text-gray-700">{{ category }}</label>
            </div>
          </div>
        </div>

        <!-- Target Audience -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Target Audience</label>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
            <div v-for="audience in audiences" :key="audience" class="flex items-center">
              <input 
                type="checkbox" 
                :id="'audience_' + audience" 
                :value="audience" 
                v-model="form.target_audience"
                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
              />
              <label :for="'audience_' + audience" class="ml-2 block text-sm text-gray-700">{{ audience }}</label>
            </div>
          </div>
        </div>

        <!-- Banner Image -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image</label>
          <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
            <div class="space-y-1 text-center">
              <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <div class="flex text-sm text-gray-600">
                <label for="file-upload" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                  <span>Upload an image</span>
                  <input id="file-upload" name="file-upload" type="file" class="sr-only" @change="handleImageUpload">
                </label>
                <p class="pl-1">or drag and drop</p>
              </div>
              <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
            </div>
          </div>
        </div>

        <!-- Terms and Conditions -->
        <div>
          <label for="terms_conditions" class="block text-sm font-medium text-gray-700">Terms & Conditions</label>
          <textarea 
            id="terms_conditions" 
            v-model="form.terms_conditions" 
            rows="3" 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Any specific rules, restrictions or terms for this campaign"
          ></textarea>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-3 pt-5 border-t border-gray-200">
          <Link 
            :href="route('advertiser.campaigns')" 
            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Cancel
          </Link>
          <button 
            type="submit" 
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            :disabled="form.processing"
          >
            <span v-if="form.processing">Processing...</span>
            <span v-else>Create Campaign</span>
          </button>
        </div>
      </form>
    </div>
  </AdvertiserLayout>
</template> 