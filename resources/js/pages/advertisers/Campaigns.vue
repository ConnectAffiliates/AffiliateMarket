<template>
    <section class="bg-[var(--sec)] h-full py-8">
        <div class="md:w-[70%] mx-auto flex flex-col gap-4 h-full">
            <div class="flex justify-between">
                <div class="flex flex-col">
                    <div class="text-2xl">Your Campaigns</div>
                    <div class="text-gray-500 text-[13px]">Manage and monitor your advertising campaigns</div>
                </div>
                <v-btn prepend-icon="mdi-plus">Create campaign</v-btn>
            </div>

            <div class="grid grid-cols-4 gap-2 py-4">
                <div class="col-span-2">
                    <v-text-field
                        density="compact"
                        label="Search campaigns"
                        prepend-inner-icon="mdi-magnify"
                        variant="outlined"
                    ></v-text-field>
                </div>
                <div class="col-span-1">
                    <v-select
                        density="compact"
                        label="Categories"
                        :items="['All', 'Electronics']"
                        variant="outlined"
                    ></v-select>
                </div>
                <div class="col-span-1">
                    <v-select
                        density="compact"
                        label="Status"
                        :items="['All', 'Active', 'Paused', 'Pending']"
                        variant="outlined"
                    ></v-select>                    
                </div>
            </div>

                <div>
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Campaign Card -->
                    <div
                        class="rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col justify-between bg-white"
                    >
                        <div>
                        <h2 class="text-lg font-semibold">Summer Tech Gadgets</h2>
                        <p class="text-sm text-gray-500 mb-2">by TechGadget Inc</p>
                        <p class="text-sm text-gray-700 mb-4">
                            Promote our latest tech gadgets with special summer discounts.
                        </p>

                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-1">
                            <span>🏷️ Electronics</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-1">
                            <span>💵 Base: 10% per sale</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-1">
                            <span class="text-purple-600">💰 Bonus: +5% for sales > $1000</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                            <span>👥 84 affiliates</span>
                        </div>
                        </div>

                        <div class="flex justify-between items-center mt-4">
                        <span class="text-xs bg-green-100 text-green-700 font-medium px-2 py-1 rounded-full">Active</span>
                        <button
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition"
                        >
                            Manage Campaign
                        </button>
                        </div>
                    </div>

                    <!-- Another Campaign Card -->
                    <div
                        class="rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col justify-between bg-white"
                    >
                        <div>
                        <h2 class="text-lg font-semibold">Fall Tech Collection</h2>
                        <p class="text-sm text-gray-500 mb-2">by TechGadget Inc</p>
                        <p class="text-sm text-gray-700 mb-4">
                            Our upcoming fall collection with new smartphones and tablets.
                        </p>

                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-1">
                            <span>🏷️ Electronics</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                            <span>💵 Base: 12% per sale</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                            <span>👥 0 affiliates</span>
                        </div>
                        </div>

                        <div class="flex justify-between items-center mt-4">
                        <span class="text-xs bg-blue-100 text-blue-700 font-medium px-2 py-1 rounded-full">Pending</span>
                        <button
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition"
                        >
                            Manage Campaign
                        </button>
                        </div>
                    </div>

                    <!-- Another Campaign Card -->
                    <div
                        class="rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col justify-between bg-white"
                    >
                        <div>
                        <h2 class="text-lg font-semibold">Budget Laptops</h2>
                        <p class="text-sm text-gray-500 mb-2">by TechGadget Inc</p>
                        <p class="text-sm text-gray-700 mb-4">
                            Affordable laptop range for students and professionals.
                        </p>

                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-1">
                            <span>🏷️ Electronics</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                            <span>💵 Base: 8% per sale</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                            <span>👥 41 affiliates</span>
                        </div>
                        </div>

                        <div class="flex justify-between items-center mt-4">
                        <span class="text-xs bg-yellow-100 text-yellow-700 font-medium px-2 py-1 rounded-full">Paused</span>
                        <button
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition"
                        >
                            Manage Campaign
                        </button>
                        </div>
                    </div>
                    </div>
                </div>
        </div>
    </section>  
</template>

<script setup>
import AdvertisersLayout from './advertisersLayout.vue';

defineOptions({ layout: AdvertisersLayout });
</script>