<template>
    <section class="bg-[var(--sec)] h-full py-8">
        <div class="md:w-[70%] mx-auto flex flex-col gap-4 h-full">
            <div class="flex flex-col">
                <div class="text-2xl">Affiliate Links</div>
                <div class="text-gray-500 text-[13px]">Track and manage affiliate links for your campaigns</div>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <div class="border rounded bg-white grid grid-cols-4 border border-gray-600 px-6 py-6">
                    <div class="col-span-3 flex flex-col gap-2">
                        <div class="text-gray-800 text-md">Active Links</div>
                        <div class="font-semibold text-2xl">24</div>
                        <div class="font-medium text-sm text-gray-500">Across 5 campaigns</div>
                    </div>
                    <div class="col-span-1 flex justify-end">
                        <div class="bg-[var(--sec)] w-8 h-8 rounded p-2 flex justify-center items-center">
                        <v-icon variant="outlined" color="primary" icon="mdi-link"></v-icon>
                        </div>
                    </div>
                </div>
                <div class="border rounded bg-white grid grid-cols-4 border border-gray-600 px-6 py-6">
                    <div class="col-span-3 flex flex-col gap-2">
                        <div class="text-gray-800 text-md">Total clicks</div>
                        <div class="font-semibold text-2xl">3,427</div>
                        <div class="font-medium text-sm text-gray-500">Last 30 days</div>
                    </div>
                    <div class="col-span-1 flex justify-end">
                        <div class="bg-[var(--sec)] w-8 h-8 rounded p-2 flex justify-center items-center">
                        <v-icon variant="outlined" color="primary" icon="mdi-cursor-default-click-outline"></v-icon>
                        </div>
                    </div>
                </div>
                <div class="border rounded bg-white grid grid-cols-4 border border-gray-600 px-6 py-6">
                    <div class="col-span-3 flex flex-col gap-2">
                        <div class="text-gray-800 text-md">Conversion Rate</div>
                        <div class="font-semibold text-2xl">2.8%</div>
                        <div class="font-medium text-sm text-gray-500">+0.3% from last month</div>
                    </div>
                    <div class="col-span-1 flex justify-end">
                        <div class="bg-[var(--sec)] w-8 h-8 rounded p-2 flex justify-center items-center">
                        <v-icon variant="outlined" color="primary" icon="mdi-chart-line-variant"></v-icon>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-4 border border-gray-600 px-6 py-6 rounded bg-white max-h-fit">
                <div class="text-gray-900 text-xl font-semibold">Your tracking links</div>
            </div>
        </div>
    </section>  
</template>

<script setup>
import AdvertisersLayout from './advertisersLayout.vue';

defineOptions({ layout: AdvertisersLayout });
</script>