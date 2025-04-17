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
  totalUsers: 256,
  totalAdvertisers: 45,
  totalAffiliates: 211,
  pendingApprovals: 8,
  monthlyRevenue: '$12,450.80',
  growthRate: '+12.5%'
})

const recentUsers = ref([
  { id: 1, name: 'Jane Cooper', email: 'jane.cooper@example.com', role: 'Advertiser', status: 'active', joinDate: '2023-05-15' },
  { id: 2, name: 'Cody Fisher', email: 'cody.fisher@example.com', role: 'Affiliate', status: 'active', joinDate: '2023-05-10' },
  { id: 3, name: 'Esther Howard', email: 'esther.howard@example.com', role: 'Affiliate', status: 'pending', joinDate: '2023-05-08' },
  { id: 4, name: 'Jenny Wilson', email: 'jenny.wilson@example.com', role: 'Advertiser', status: 'active', joinDate: '2023-05-05' },
  { id: 5, name: 'Kristin Watson', email: 'kristin.watson@example.com', role: 'Affiliate', status: 'pending', joinDate: '2023-05-03' }
])

const pendingApprovals = ref([
  { id: 1, name: 'Esther Howard', type: 'Affiliate', date: '2023-05-08', description: 'New affiliate registration' },
  { id: 2, name: 'Kristin Watson', type: 'Affiliate', date: '2023-05-03', description: 'New affiliate registration' },
  { id: 3, name: 'Cameron Williamson', type: 'Campaign', date: '2023-05-12', description: 'Product launch campaign approval' },
  { id: 4, name: 'Brooklyn Simmons', type: 'Payout', date: '2023-05-14', description: 'Payout request for $450.00' }
])

const searchQuery = ref('')
const filteredUsers = computed(() => {
  if (searchQuery.value === '') return recentUsers.value
  const query = searchQuery.value.toLowerCase()
  return recentUsers.value.filter(user => 
    user.name.toLowerCase().includes(query) || 
    user.email.toLowerCase().includes(query) ||
    user.role.toLowerCase().includes(query)
  )
})
</script>

<template>
  <Head title="Admin Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <div class="px-4 sm:px-0">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Admin Dashboard
        </h2>
        <p class="mt-1 text-sm text-gray-600">Manage users, campaigns and system operations</p>
      </div>
    </template>

    <div class="py-6 sm:py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-indigo-50 rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
              <div class="ml-4">
                <h3 class="text-lg font-medium text-gray-700">Total Users</h3>
                <div class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.totalUsers }}</div>
                <div class="mt-1 text-sm text-gray-500">
                  {{ stats.totalAdvertisers }} Advertisers, {{ stats.totalAffiliates }} Affiliates
                </div>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-amber-50 rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-4">
                <h3 class="text-lg font-medium text-gray-700">Monthly Revenue</h3>
                <div class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.monthlyRevenue }}</div>
                <div class="mt-1 font-medium text-green-600">{{ stats.growthRate }}</div>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-blue-50 rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-4">
                <h3 class="text-lg font-medium text-gray-700">Pending Approvals</h3>
                <div class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.pendingApprovals }}</div>
                <div class="mt-1">
                  <a href="#approvals" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                    View pending items
                  </a>
                </div>
              </div>
            </div>
          </div>
          
          <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl shadow-sm p-4 sm:p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-white bg-opacity-20 rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-4">
                <h3 class="text-lg font-medium text-white">Admin Actions</h3>
                <div class="mt-2 text-sm text-white text-opacity-90">
                  <a href="#" class="inline-flex items-center px-3 py-1.5 border border-white border-opacity-30 rounded-md bg-white bg-opacity-10 hover:bg-opacity-20 text-white font-medium text-sm">
                    System Settings
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Main content -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Recent Users - takes 2 of 3 columns on large screens -->
          <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-gray-200">
              <h3 class="text-base font-semibold text-gray-900">Recent Users</h3>
              <div class="mt-3 sm:mt-0 relative">
                <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Search users..."
                  class="w-full sm:w-64 pr-10 pl-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                </div>
              </div>
            </div>
            
            <!-- Table view (hidden on mobile) -->
            <div class="hidden md:block overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                    <th scope="col" class="relative px-6 py-3">
                      <span class="sr-only">Actions</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="user in filteredUsers" :key="user.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                          <span class="text-gray-500 font-medium">{{ user.name.charAt(0) }}</span>
                        </div>
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                          <div class="text-sm text-gray-500">{{ user.email }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full"
                            :class="{
                              'bg-indigo-100 text-indigo-800': user.role === 'Advertiser',
                              'bg-green-100 text-green-800': user.role === 'Affiliate'
                            }">
                        {{ user.role }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full"
                            :class="{
                              'bg-green-100 text-green-800': user.status === 'active',
                              'bg-yellow-100 text-yellow-800': user.status === 'pending'
                            }">
                        {{ user.status }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                      {{ user.joinDate }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                      <a href="#" class="text-red-600 hover:text-red-900">Suspend</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            
            <!-- Card view (visible only on mobile) -->
            <div class="block md:hidden">
              <ul role="list" class="divide-y divide-gray-200">
                <li v-for="user in filteredUsers" :key="user.id" class="px-4 py-4">
                  <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                      <span class="text-gray-500 font-medium">{{ user.name.charAt(0) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-900 truncate">{{ user.name }}</p>
                      <p class="text-sm text-gray-500 truncate">{{ user.email }}</p>
                      <div class="mt-1 flex items-center">
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full mr-2"
                              :class="{
                                'bg-indigo-100 text-indigo-800': user.role === 'Advertiser',
                                'bg-green-100 text-green-800': user.role === 'Affiliate'
                              }">
                          {{ user.role }}
                        </span>
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full"
                              :class="{
                                'bg-green-100 text-green-800': user.status === 'active',
                                'bg-yellow-100 text-yellow-800': user.status === 'pending'
                              }">
                          {{ user.status }}
                        </span>
                      </div>
                    </div>
                    <div>
                      <button class="inline-flex items-center p-1.5 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                      </button>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            
            <div class="px-4 py-4 sm:px-6 border-t border-gray-200 bg-gray-50 flex justify-between items-center">
              <div class="text-sm text-gray-500">
                Showing {{ filteredUsers.length }} of {{ recentUsers.length }} users
              </div>
              <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                View all users<span aria-hidden="true"> &rarr;</span>
              </a>
            </div>
          </div>
          
          <!-- Pending Approvals - takes 1 of 3 columns -->
          <div id="approvals" class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="p-4 sm:p-6 border-b border-gray-200">
              <h3 class="text-base font-semibold text-gray-900">Pending Approvals</h3>
            </div>
            <ul role="list" class="divide-y divide-gray-200">
              <li v-for="item in pendingApprovals" :key="item.id" class="p-4 sm:px-6 sm:py-4">
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                      <span class="text-gray-500 font-medium">{{ item.name.charAt(0) }}</span>
                    </div>
                    <div class="ml-3">
                      <p class="text-sm font-medium text-gray-900">{{ item.name }}</p>
                      <div class="flex items-center mt-1">
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full"
                              :class="{
                                'bg-indigo-100 text-indigo-800': item.type === 'Affiliate',
                                'bg-purple-100 text-purple-800': item.type === 'Campaign',
                                'bg-amber-100 text-amber-800': item.type === 'Payout'
                              }">
                          {{ item.type }}
                        </span>
                        <span class="ml-2 text-xs text-gray-500">{{ item.date }}</span>
                      </div>
                      <p class="mt-1 text-xs text-gray-500">{{ item.description }}</p>
                    </div>
                  </div>
                  <div class="flex space-x-2">
                    <button class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                      Approve
                    </button>
                    <button class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                      Reject
                    </button>
                  </div>
                </div>
              </li>
            </ul>
            <div class="px-4 py-4 sm:px-6 border-t border-gray-200 bg-gray-50 text-right">
              <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                View all pending items<span aria-hidden="true"> &rarr;</span>
              </a>
            </div>
          </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="p-4 sm:p-6 border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-900">Quick Actions</h3>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-gray-200">
            <a href="#" class="block p-6 text-center hover:bg-gray-50">
              <div class="mx-auto h-12 w-12 rounded-full bg-indigo-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
              </div>
              <h3 class="mt-3 text-sm font-medium text-gray-900">Add User</h3>
              <p class="mt-1 text-xs text-gray-500">Create new admin, advertiser or affiliate</p>
            </a>
            <a href="#" class="block p-6 text-center hover:bg-gray-50">
              <div class="mx-auto h-12 w-12 rounded-full bg-green-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
              </div>
              <h3 class="mt-3 text-sm font-medium text-gray-900">Manage Campaigns</h3>
              <p class="mt-1 text-xs text-gray-500">Review and moderate all campaigns</p>
            </a>
            <a href="#" class="block p-6 text-center hover:bg-gray-50">
              <div class="mx-auto h-12 w-12 rounded-full bg-amber-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
              <h3 class="mt-3 text-sm font-medium text-gray-900">Process Payouts</h3>
              <p class="mt-1 text-xs text-gray-500">Review and approve payment requests</p>
            </a>
            <a href="#" class="block p-6 text-center hover:bg-gray-50">
              <div class="mx-auto h-12 w-12 rounded-full bg-blue-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
              <h3 class="mt-3 text-sm font-medium text-gray-900">System Settings</h3>
              <p class="mt-1 text-xs text-gray-500">Manage platform configurations</p>
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