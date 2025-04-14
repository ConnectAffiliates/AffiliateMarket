<script setup>
import {
  Chart,
  Title,
  Tooltip,
  Legend,
  PointElement,
  LineElement,
  BarElement,
  ArcElement,
  CategoryScale,
  LinearScale,
} from 'chart.js'

import { Bar } from 'vue-chartjs'

import {ref} from "vue"

const tab = ref('overview')


Chart.register(
  CategoryScale,
  LinearScale,
  BarElement,
  ArcElement,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
)

const data = {
  labels: ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'],
  datasets: [
    {
      label: 'Requests',
      data: [40, 20, 12, 30, 40, 20, 12],
      backgroundColor: ['rgb(24, 103, 192,0.9)'],
      borderColor: ['rgb(24, 103, 192)'],
      borderWidth: 1,
    },
  ],
}

const options = {
  responsive: true,
}
</script>

<template>
  <section class="bg-[var(--sec)] h-full py-8">
    <div class="md:w-[70%] mx-auto flex flex-col gap-4 h-full">
      <div class="flex flex-col">
        <div class="text-2xl">Dashboard</div>
        <div class="text-gray-500 text-[13px]">Welcome back to WingaApp</div>
      </div>
      <div class="grid grid-cols-4 gap-2">
        <div class="border rounded bg-white grid grid-cols-4 border border-gray-600 px-6 py-6">
          <div class="col-span-3 flex flex-col gap-2">
            <div class="text-gray-500 text-md">Campaign Spend</div>
            <div class="font-semibold text-2xl">$ 12,543.00 </div>
          </div>
          <div class="col-span-1 flex justify-end">
            <div class="bg-[var(--sec)] w-8 h-8 rounded p-2 flex justify-center items-center">
              <v-icon
                variant="outlined"
                color="primary"
                icon="mdi-account-multiple-outline"
              ></v-icon>
            </div>
          </div>
        </div>
        <div class="border rounded bg-white grid grid-cols-4 border border-gray-600 px-6 py-6">
          <div class="col-span-3 flex flex-col gap-2">
            <div class="text-gray-500 text-md">Active Affiliates</div>
            <div class="font-semibold text-2xl">10</div>
          </div>
          <div class="col-span-1 flex justify-end">
            <div class="bg-[var(--sec)] w-8 h-8 rounded p-2 flex justify-center items-center">
              <v-icon variant="outlined" color="primary" icon="mdi-bank-outline"></v-icon>
            </div>
          </div>
        </div>
        <div class="border rounded bg-white grid grid-cols-4 border border-gray-600 px-6 py-6">
          <div class="col-span-3 flex flex-col gap-2">
            <div class="text-gray-500 text-md">Conversions</div>
            <div class="font-semibold text-2xl">1,024</div>
          </div>
          <div class="col-span-1 flex justify-end">
            <div class="bg-[var(--sec)] w-8 h-8 rounded p-2 flex justify-center items-center">
              <v-icon variant="outlined" color="primary" icon="mdi-link-variant"></v-icon>
            </div>
          </div>
        </div>
        <div class="border rounded bg-white grid grid-cols-4 border border-gray-600 px-6 py-6">
          <div class="col-span-3 flex flex-col gap-2">
            <div class="text-gray-500 text-md">ROI</div>
            <div class="font-semibold text-2xl">214%</div>
          </div>
          <div class="col-span-1 flex justify-end">
            <div class="bg-[var(--sec)] w-8 h-8 rounded p-2 flex justify-center items-center">
              <v-icon variant="outlined" color="primary" icon="mdi-key-outline"></v-icon>
            </div>
          </div>
        </div>
      </div>
      <div class="grid grid-cols-5 gap-2">

        <div class="col-span-3 border border-gray-600 px-6 py-6 rounded bg-white max-h-fit">

            <div class="flex flex-row gap-8 bg-gray-200 w-fit px-2 py-2 rounded">
            <div
            @click="tab='overview'"
            :class="tab=='overview' ? 'bg-white px-1 rounded shadow' : ''"
            class="cursor-pointer transition-all duration-200 ease-in"
            >
            Overview
            </div>
            <div
            @click="tab='campaigns'"
            :class="tab=='campaigns' ? 'bg-white px-1 rounded shadow' : ''"
            class="cursor-pointer transition-all duration-200 ease-in"
            >
            Campaigns
            </div>
            <div
            @click="tab='affiliateLinks'"
            :class="tab=='affiliateLinks' ? 'bg-white px-1 rounded shadow' : ''"
            class="cursor-pointer transition-all duration-200 ease-in"
            >
            Affiliate Links
            </div>
            <div
            @click="tab='payouts'"
            :class="tab=='payouts' ? 'bg-white px-1 rounded shadow' : ''"
            class="cursor-pointer transition-all duration-200 ease-in"
            >
            Payouts
            </div>
        </div>
            
          <div class="text-gray-900 text-lg">API Requests (Last 7 days)</div>
          <Bar :data="data" :options="options" />
        </div>
        <div class="col-span-2 border border-gray-600 px-6 py-6 rounded bg-white">
          <div class="text-gray-900 text-lg">Recent Activity</div>
          <div v-for="i in 5" class="grid grid-cols-6 min-w-fit my-4 border-b border-gray-400 py-2">
            <div class="col-span-1">
              <div
                class="bg-[var(--sec)] w-9 h-9 rounded-full p-2 flex justify-center items-center"
              >
                <v-icon icon="mdi-chevron-right"></v-icon>
              </div>
            </div>
            <div class="col-span-3">
              <div>New request </div>
              <div class="col-span-2 text-gray-500 text-[13px]">By James Potter</div>
            </div>
            <div class="col-span-2 text-gray-500 text-[13px]">5 minutes ago</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

