<script setup lang="ts">
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
const currentRoute = computed(() => page.url)

const navItems = [
  {
    name: 'Dashboard',
    icon: 'home',
    route: '/admin/dashboard',
  },
  {
    name: 'Users',
    icon: 'users',
    route: '/admin/users',
  },
  {
    name: 'Campaigns',
    icon: 'globe',
    route: '/admin/campaigns',
  },
  {
    name: 'Analytics',
    icon: 'chart-bar',
    route: '/admin/analytics',
  },
  {
    name: 'Transactions',
    icon: 'credit-card',
    route: '/admin/transactions',
  },
  {
    name: 'Settings',
    icon: 'cog',
    route: '/admin/settings',
  },
]

const isActive = (route: string) => {
  return currentRoute.value === route || currentRoute.value.startsWith(`${route}/`)
}
</script>

<template>
  <div class="h-full flex flex-col bg-white shadow-sm border-r border-gray-200">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 border-b border-gray-200 px-4">
      <Link href="/" class="flex items-center space-x-2">
        <span class="text-xl font-bold text-indigo-600">Affiliate</span>
        <span class="text-xl font-bold text-gray-900">Market</span>
      </Link>
    </div>
    
    <!-- Nav Items -->
    <div class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
      <Link 
        v-for="item in navItems" 
        :key="item.name" 
        :href="item.route"
        class="flex items-center px-4 py-3 rounded-md text-sm font-medium transition-colors duration-150"
        :class="isActive(item.route) ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100'"
      >
        <span class="text-indigo-500 mr-3" :class="{ 'text-indigo-700': isActive(item.route) }">
          <svg v-if="item.icon === 'home'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          <svg v-else-if="item.icon === 'users'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
          <svg v-else-if="item.icon === 'globe'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
          </svg>
          <svg v-else-if="item.icon === 'chart-bar'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
          <svg v-else-if="item.icon === 'credit-card'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
          </svg>
          <svg v-else-if="item.icon === 'cog'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </span>
        {{ item.name }}
      </Link>
    </div>
    
    <!-- Bottom Section -->
    <div class="p-4 border-t border-gray-200">
      <div class="flex flex-col">
        <div class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">
          Platform Status
        </div>
        <div class="flex items-center">
          <span class="h-2 w-2 rounded-full bg-green-500 mr-2"></span>
          <span class="text-sm text-gray-700">All systems operational</span>
        </div>
      </div>
    </div>
  </div>
</template> 