<script setup lang="ts">
import { ref, computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { PageProps } from '@/types'

const showingNavigationDropdown = ref(false)

const user = usePage<{ auth: { user: { id: string, first_name: string, last_name: string, email: string, roles: { name: string }[] } } }>().props.auth.user

// Determine the dashboard route name based on the first role
const dashboardRouteName = computed(() => {
  if (!user || !user.roles || user.roles.length === 0) {
    return 'dashboard'; // Fallback or default dashboard
  }
  const roleName = user.roles[0].name;
  switch (roleName) {
    case 'admin':
      return 'admin.dashboard';
    case 'advertiser':
      return 'advertiser.dashboard';
    case 'affiliate':
      return 'affiliate.dashboard';
    default:
      return 'dashboard'; // Fallback
  }
});
</script>

<template>
  <div>
    <nav class="bg-white border-b border-gray-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="shrink-0 flex items-center">
              <Link :href="route('home')">
                <img class="block h-9 w-auto" src="/logo.svg" alt="Logo" />
              </Link>
            </div>

            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
              <Link
                :href="route(dashboardRouteName)"
                class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"
                :class="{ 'border-emerald-500 text-gray-900': route().current(dashboardRouteName) }"
              >
                Dashboard
              </Link>
            </div>
          </div>

          <div class="hidden sm:flex sm:items-center sm:ml-6">
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

          <div class="-mr-2 flex items-center sm:hidden">
            <button
              @click="showingNavigationDropdown = !showingNavigationDropdown"
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
            >
              <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path
                  :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                  class="inline-flex"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
                <path
                  :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                  class="hidden"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
          <Link
            :href="route(dashboardRouteName)"
            class="block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out"
            :class="{ 'border-emerald-500 text-emerald-700 bg-emerald-50 focus:text-emerald-800 focus:bg-emerald-50 focus:border-emerald-700': route().current(dashboardRouteName) }"
          >
            Dashboard
          </Link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
          <div class="px-4">
            <div class="font-medium text-base text-gray-800">{{ user.first_name }} {{ user.last_name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ user.email }}</div>
          </div>

          <div class="mt-3 space-y-1">
            <Link
              :href="route('logout')"
              method="post"
              as="button"
              class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100"
            >
              Log Out
            </Link>
          </div>
        </div>
      </div>
    </nav>

    <main>
      <slot />
    </main>
  </div>
</template> 