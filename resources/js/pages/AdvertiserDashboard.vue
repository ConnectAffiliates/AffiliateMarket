<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { 
  ChartBarIcon, 
  CurrencyDollarIcon, 
  LinkIcon, 
  UserGroupIcon, 
  ArrowTrendingUpIcon,
  DocumentTextIcon,
  CogIcon
} from '@heroicons/vue/24/solid';

// Define interfaces for type safety
interface Campaign {
  id: string;
  name: string;
  clicks: number;
  conversions: number;
  earnings: number;
  status: string;
}

interface Transaction {
  id: string;
  date: string;
  amount: number;
  type: string;
  status: string;
}

interface DashboardStats {
  total_earnings: number;
  active_campaigns: number;
  total_clicks: number;
  conversion_rate: number;
}

// Props to receive data from the backend with default values
const props = withDefaults(defineProps<{
  stats?: DashboardStats;
  recentCampaigns?: Campaign[];
  recentTransactions?: Transaction[];
}>(), {
  stats: () => ({
    total_earnings: 0,
    active_campaigns: 0,
    total_clicks: 0,
    conversion_rate: 0
  }),
  recentCampaigns: () => [],
  recentTransactions: () => []
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/advertiser/dashboard',
  },
];

// Function to format currency in Tsh
const formatCurrency = (value: number) => {
  return new Intl.NumberFormat('en-TZ', {
    style: 'currency',
    currency: 'TZS',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0
  }).format(value);
};

// Function to format date
const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
};

// Function to get status color
const getStatusColor = (status: string) => {
  switch (status) {
    case 'active':
      return 'bg-green-100 text-green-800';
    case 'paused':
      return 'bg-yellow-100 text-yellow-800';
    case 'completed':
      return 'bg-blue-100 text-blue-800';
    case 'cancelled':
      return 'bg-red-100 text-red-800';
    case 'paid':
      return 'bg-green-100 text-green-800';
    case 'pending':
      return 'bg-yellow-100 text-yellow-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
};

// Navigation functions
const navigateTo = (route: string) => {
  router.visit(route);
};
</script>

<template>
  <Head title="Advertiser Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="min-h-screen bg-gray-50">
      <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold text-gray-900">Advertiser Dashboard</h1>
          <p class="mt-1 text-sm text-gray-500">Manage your campaigns and track performance</p>
        </div>
      </header>
      
      <main>
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <!-- Stats Overview -->
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white overflow-hidden shadow rounded-lg transition-all duration-300 hover:shadow-md">
              <div class="p-5">
                <div class="flex items-center">
                  <div class="flex-shrink-0 bg-emerald-100 rounded-md p-2">
                    <CurrencyDollarIcon class="h-6 w-6 text-emerald-600" aria-hidden="true" />
                  </div>
                  <div class="ml-5 w-0 flex-1">
                    <dl>
                      <dt class="text-sm font-medium text-gray-500 truncate">Total Spent</dt>
                      <dd class="flex items-baseline">
                        <div class="text-2xl font-semibold text-gray-900">{{ formatCurrency(props.stats.total_earnings) }}</div>
                      </dd>
                    </dl>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg transition-all duration-300 hover:shadow-md">
              <div class="p-5">
                <div class="flex items-center">
                  <div class="flex-shrink-0 bg-emerald-100 rounded-md p-2">
                    <LinkIcon class="h-6 w-6 text-emerald-600" aria-hidden="true" />
                  </div>
                  <div class="ml-5 w-0 flex-1">
                    <dl>
                      <dt class="text-sm font-medium text-gray-500 truncate">Active Campaigns</dt>
                      <dd class="flex items-baseline">
                        <div class="text-2xl font-semibold text-gray-900">{{ props.stats.active_campaigns }}</div>
                      </dd>
                    </dl>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg transition-all duration-300 hover:shadow-md">
              <div class="p-5">
                <div class="flex items-center">
                  <div class="flex-shrink-0 bg-emerald-100 rounded-md p-2">
                    <UserGroupIcon class="h-6 w-6 text-emerald-600" aria-hidden="true" />
                  </div>
                  <div class="ml-5 w-0 flex-1">
                    <dl>
                      <dt class="text-sm font-medium text-gray-500 truncate">Total Clicks</dt>
                      <dd class="flex items-baseline">
                        <div class="text-2xl font-semibold text-gray-900">{{ props.stats.total_clicks }}</div>
                      </dd>
                    </dl>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg transition-all duration-300 hover:shadow-md">
              <div class="p-5">
                <div class="flex items-center">
                  <div class="flex-shrink-0 bg-emerald-100 rounded-md p-2">
                    <ArrowTrendingUpIcon class="h-6 w-6 text-emerald-600" aria-hidden="true" />
                  </div>
                  <div class="ml-5 w-0 flex-1">
                    <dl>
                      <dt class="text-sm font-medium text-gray-500 truncate">Conversion Rate</dt>
                      <dd class="flex items-baseline">
                        <div class="text-2xl font-semibold text-gray-900">{{ (props.stats.conversion_rate * 100).toFixed(2) }}%</div>
                      </dd>
                    </dl>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Actions -->
          <div class="mt-8">
            <h2 class="text-lg font-medium text-gray-900">Quick Actions</h2>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
              <button @click="navigateTo('/advertiser/campaigns/create')" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-emerald-500 hover:shadow-md transition-all duration-300 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                <div class="flex-shrink-0 bg-emerald-100 rounded-md p-2">
                  <LinkIcon class="h-6 w-6 text-emerald-600" aria-hidden="true" />
                </div>
                <div class="flex-1 min-w-0">
                  <span class="absolute inset-0" aria-hidden="true" />
                  <p class="text-sm font-medium text-gray-900">Create Campaign</p>
                  <p class="text-sm text-gray-500">Start a new campaign</p>
                </div>
              </button>
              <button @click="navigateTo('/advertiser/analytics')" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-emerald-500 hover:shadow-md transition-all duration-300 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                <div class="flex-shrink-0 bg-emerald-100 rounded-md p-2">
                  <ChartBarIcon class="h-6 w-6 text-emerald-600" aria-hidden="true" />
                </div>
                <div class="flex-1 min-w-0">
                  <span class="absolute inset-0" aria-hidden="true" />
                  <p class="text-sm font-medium text-gray-900">Analytics</p>
                  <p class="text-sm text-gray-500">View performance data</p>
                </div>
              </button>
              <button @click="navigateTo('/advertiser/affiliates')" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-emerald-500 hover:shadow-md transition-all duration-300 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                <div class="flex-shrink-0 bg-emerald-100 rounded-md p-2">
                  <UserGroupIcon class="h-6 w-6 text-emerald-600" aria-hidden="true" />
                </div>
                <div class="flex-1 min-w-0">
                  <span class="absolute inset-0" aria-hidden="true" />
                  <p class="text-sm font-medium text-gray-900">Affiliates</p>
                  <p class="text-sm text-gray-500">Manage affiliates</p>
                </div>
              </button>
              <button @click="navigateTo('/advertiser/settings')" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-emerald-500 hover:shadow-md transition-all duration-300 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                <div class="flex-shrink-0 bg-emerald-100 rounded-md p-2">
                  <CogIcon class="h-6 w-6 text-emerald-600" aria-hidden="true" />
                </div>
                <div class="flex-1 min-w-0">
                  <span class="absolute inset-0" aria-hidden="true" />
                  <p class="text-sm font-medium text-gray-900">Settings</p>
                  <p class="text-sm text-gray-500">Manage your account</p>
                </div>
              </button>
            </div>
          </div>

          <!-- Recent Campaigns -->
          <div class="mt-8">
            <div class="sm:flex sm:items-center">
              <div class="sm:flex-auto">
                <h2 class="text-lg font-medium text-gray-900">Recent Campaigns</h2>
                <p class="mt-2 text-sm text-gray-700">A list of your recent campaigns and their performance.</p>
              </div>
              <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button @click="navigateTo('/advertiser/campaigns')" class="inline-flex items-center justify-center rounded-md border border-transparent bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 sm:w-auto transition-colors duration-300">
                  View All
                </button>
              </div>
            </div>
            <div class="mt-4 flex flex-col">
              <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                  <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                      <thead class="bg-gray-50">
                        <tr>
                          <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Campaign</th>
                          <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Clicks</th>
                          <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Conversions</th>
                          <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Cost</th>
                          <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-if="props.recentCampaigns.length === 0">
                          <td colspan="5" class="px-3 py-4 text-sm text-gray-500 text-center">No campaigns found</td>
                        </tr>
                        <tr v-for="campaign in props.recentCampaigns" :key="campaign.id" @click="navigateTo(`/advertiser/campaigns/${campaign.id}`)" class="cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                          <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                            {{ campaign.name }}
                          </td>
                          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ campaign.clicks }}</td>
                          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ campaign.conversions }}</td>
                          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ formatCurrency(campaign.earnings) }}</td>
                          <td class="whitespace-nowrap px-3 py-4 text-sm">
                            <span :class="[getStatusColor(campaign.status), 'inline-flex rounded-full px-2 text-xs font-semibold leading-5']">
                              {{ campaign.status }}
                            </span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent Payments -->
          <div class="mt-8">
            <div class="sm:flex sm:items-center">
              <div class="sm:flex-auto">
                <h2 class="text-lg font-medium text-gray-900">Recent Payments</h2>
                <p class="mt-2 text-sm text-gray-700">A list of your recent payments to affiliates.</p>
              </div>
              <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button @click="navigateTo('/advertiser/payments')" class="inline-flex items-center justify-center rounded-md border border-transparent bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 sm:w-auto transition-colors duration-300">
                  View All
                </button>
              </div>
            </div>
            <div class="mt-4 flex flex-col">
              <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                  <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                      <thead class="bg-gray-50">
                        <tr>
                          <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Date</th>
                          <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                          <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Amount</th>
                          <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-if="props.recentTransactions.length === 0">
                          <td colspan="4" class="px-3 py-4 text-sm text-gray-500 text-center">No transactions found</td>
                        </tr>
                        <tr v-for="transaction in props.recentTransactions" :key="transaction.id" class="cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                          <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                            {{ formatDate(transaction.date) }}
                          </td>
                          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ transaction.type }}</td>
                          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ formatCurrency(transaction.amount) }}</td>
                          <td class="whitespace-nowrap px-3 py-4 text-sm">
                            <span :class="[getStatusColor(transaction.status), 'inline-flex rounded-full px-2 text-xs font-semibold leading-5']">
                              {{ transaction.status }}
                            </span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </AppLayout>
</template> 