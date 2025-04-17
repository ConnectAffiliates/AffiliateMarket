<script setup lang="ts">
import { ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { PageProps } from '@/types'

const showingSidebar = ref(true)
const toggleSidebar = () => {
  showingSidebar.value = !showingSidebar.value
}

const user = usePage<{ auth: { user: { id: string, first_name: string, last_name: string, email: string, roles: { name: string }[] } } }>().props.auth.user
</script>

<template>
  <div class="h-screen flex overflow-hidden bg-gray-100">
    <!-- Sidebar -->
    <div :class="{ 'hidden': !showingSidebar, 'block': showingSidebar }" class="md:flex md:flex-shrink-0">
      <div class="flex flex-col w-64">
        <div class="flex flex-col h-0 flex-1 bg-white border-r border-gray-200">
          <div class="flex items-center h-16 flex-shrink-0 px-4 bg-indigo-700">
            <Link :href="route('home')" class="flex items-center">
              <img class="h-8 w-auto" src="/logo.svg" alt="Logo" />
              <span class="ml-2 text-white font-semibold text-lg">AffiliateMarket</span>
            </Link>
          </div>
          <div class="flex-1 flex flex-col overflow-y-auto">
            <nav class="flex-1 px-2 py-4 space-y-1">
              <Link 
                :href="route('advertiser.dashboard')" 
                class="group flex items-center px-2 py-2 text-sm font-medium rounded-md" 
                :class="[route().current('advertiser.dashboard') ? 'bg-indigo-100 text-indigo-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900']"
              >
                <svg class="mr-3 h-6 w-6" :class="[route().current('advertiser.dashboard') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500']" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
              </Link>

              <Link 
                :href="route('advertiser.campaigns')" 
                class="group flex items-center px-2 py-2 text-sm font-medium rounded-md" 
                :class="[route().current('advertiser.campaigns*') ? 'bg-indigo-100 text-indigo-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900']"
              >
                <svg class="mr-3 h-6 w-6" :class="[route().current('advertiser.campaigns*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500']" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Campaigns
              </Link>

              <Link 
                :href="route('advertiser.referrals')" 
                class="group flex items-center px-2 py-2 text-sm font-medium rounded-md" 
                :class="[route().current('advertiser.referrals*') ? 'bg-indigo-100 text-indigo-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900']"
              >
                <svg class="mr-3 h-6 w-6" :class="[route().current('advertiser.referrals*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500']" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
                Referral Codes
              </Link>

              <Link 
                :href="route('advertiser.verify-sales')" 
                class="group flex items-center px-2 py-2 text-sm font-medium rounded-md" 
                :class="[route().current('advertiser.verify-sales*') ? 'bg-indigo-100 text-indigo-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900']"
              >
                <svg class="mr-3 h-6 w-6" :class="[route().current('advertiser.verify-sales*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500']" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Verify Sales
              </Link>

              <Link 
                :href="route('advertiser.affiliates')" 
                class="group flex items-center px-2 py-2 text-sm font-medium rounded-md" 
                :class="[route().current('advertiser.affiliates*') ? 'bg-indigo-100 text-indigo-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900']"
              >
                <svg class="mr-3 h-6 w-6" :class="[route().current('advertiser.affiliates*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500']" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Affiliates
              </Link>

              <Link 
                :href="route('advertiser.payouts')" 
                class="group flex items-center px-2 py-2 text-sm font-medium rounded-md" 
                :class="[route().current('advertiser.payouts*') ? 'bg-indigo-100 text-indigo-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900']"
              >
                <svg class="mr-3 h-6 w-6" :class="[route().current('advertiser.payouts*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500']" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Payouts
              </Link>

              <Link 
                :href="route('advertiser.settings')" 
                class="group flex items-center px-2 py-2 text-sm font-medium rounded-md" 
                :class="[route().current('advertiser.settings*') ? 'bg-indigo-100 text-indigo-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900']"
              >
                <svg class="mr-3 h-6 w-6" :class="[route().current('advertiser.settings*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500']" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Settings
              </Link>
            </nav>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col w-0 flex-1 overflow-hidden">
      <div class="md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3">
        <button 
          @click="toggleSidebar"
          class="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
        >
          <span class="sr-only">Open sidebar</span>
          <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
      
      <main class="flex-1 relative z-0 overflow-y-auto focus:outline-none">
        <!-- Top Navigation Bar -->
        <div class="bg-white shadow">
          <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
              <div class="flex">
                <slot name="header"></slot>
              </div>
              <div class="flex items-center">
                <!-- User Profile Dropdown -->
                <div class="ml-3 relative">
                  <div class="flex items-center">
                    <span class="text-gray-700 mr-4">{{ user.first_name }} {{ user.last_name }}</span>
                    <Link
                      :href="route('logout')"
                      method="post"
                      as="button"
                      class="text-sm text-gray-500 hover:text-gray-700"
                    >
                      Log Out
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Page Content -->
        <div class="py-6">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <slot></slot>
          </div>
        </div>
      </main>
    </div>
  </div>
</template> 