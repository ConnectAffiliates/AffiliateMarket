<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3';

const drawer = ref(false)
</script>

<template>
  <v-card>
    <v-layout>
      <v-navigation-drawer width="300" class="bg-[var(--pri)]" color="primary" expand-on-hover rail>
        <v-list>
          <v-list-item prepend-icon="mdi-lan-connect" title="WingaApp">
            <template v-slot:title>
              <span class="text-xl font-bold">WingaApp</span>
            </template>
          </v-list-item>
        </v-list>

        <v-divider></v-divider>

        <v-list density="compact" nav>
            <Link :href="route('advertiser.dashboard')">
                <v-list-item  prepend-icon="mdi-view-dashboard" value="Dashboard">
                    <template v-slot:title>
                    <span class="text-lg">Dashboard</span>
                    <!-- Custom title -->
                    </template>
                </v-list-item>
            </Link>
            <Link :href="route('advertiser.campaigns')">
                <v-list-item
                    prepend-icon="mdi-chart-line-variant"
                    title="Campaigns"
                    value="Campaigns"
                >
                    <template v-slot:title>
                    <span class="text-lg">Campaigns</span>
                    <!-- Custom title -->
                    </template>
                </v-list-item>
            </Link>
            <Link :href="route('advertiser.affiliateLinks')">
                <v-list-item prepend-icon="mdi-link" title="api-keys" value="api-keys">
                    <template v-slot:title>
                    <span class="text-lg">Affiliate Links</span>
                    <!-- Custom title -->
                    </template>
                </v-list-item>
            </Link>
            <Link :href="route('advertiser.payouts')">
                <v-list-item
                    prepend-icon="mdi-currency-usd"
                    title="Payouts"
                    value="Payouts"
                >
                    <template v-slot:title>
                    <span class="text-lg">Payouts</span>
                    <!-- Custom title -->
                    </template>
                </v-list-item>
            </Link>
        </v-list>
      </v-navigation-drawer>

      <v-main style="height: 100vh" class="flex flex-col">
        <v-app-bar color="white" class="elevation-0 px-4">
          <v-toolbar-title>
            <div class="text-xl font-bold text-gray-800">WingaApp</div>
          </v-toolbar-title>

          <v-app-bar-nav-icon
            class="opacity-0"
            variant="text"
            @click.stop="drawer = !drawer"
          ></v-app-bar-nav-icon>

          <v-btn color="primary" icon="mdi-logout" title="Logout" variant="outlined"></v-btn>
        </v-app-bar>
        <div class="h-full w-full">
          <!-- <router-view></router-view> -->
           <slot/>
        </div>
      </v-main>
    </v-layout>
  </v-card>
</template>
