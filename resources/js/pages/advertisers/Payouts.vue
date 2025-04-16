<template>
    <section class="bg-[var(--sec)] h-full py-8">
        <div class="md:w-[70%] mx-auto flex flex-col gap-4 h-full">
            <div class="flex flex-col">
                <div class="text-2xl">Payouts</div>
                <div class="text-gray-500 text-[13px]">Manage commission payouts to your affiliates</div>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <div class="border rounded bg-white grid grid-cols-4 border border-gray-600 px-6 py-6">
                    <div class="col-span-3 flex flex-col gap-2">
                        <div class="text-gray-800 text-md">Total Paid</div>
                        <div class="font-semibold text-2xl">$45,231.89</div>
                        <div class="font-medium text-sm text-gray-500">+20.1% from last month</div>
                    </div>
                    <div class="col-span-1 flex justify-end">
                        <div class="bg-[var(--sec)] w-8 h-8 rounded p-2 flex justify-center items-center">
                        <v-icon variant="outlined" color="primary" icon="mdi-currency-usd"></v-icon>
                        </div>
                    </div>
                </div>
                <div class="border rounded bg-white grid grid-cols-4 border border-gray-600 px-6 py-6">
                    <div class="col-span-3 flex flex-col gap-2">
                        <div class="text-gray-800 text-md">Pending Payments</div>
                        <div class="font-semibold text-2xl">$4,575.00</div>
                        <div class="font-medium text-sm text-gray-500">15 transactions pending</div>
                    </div>
                    <div class="col-span-1 flex justify-end">
                        <div class="bg-[var(--sec)] w-8 h-8 rounded p-2 flex justify-center items-center">
                        <v-icon variant="outlined" color="primary" icon="mdi-receipt-clock-outline"></v-icon>
                        </div>
                    </div>
                </div>
                <div class="border rounded bg-white grid grid-cols-4 border border-gray-600 px-6 py-6">
                    <div class="col-span-3 flex flex-col gap-2">
                        <div class="text-gray-800 text-md">ROI</div>
                        <div class="font-semibold text-2xl">214%</div>
                        <div class="font-medium text-sm text-gray-500">Processed on Apr 1,2025</div>
                    </div>
                    <div class="col-span-1 flex justify-end">
                        <div class="bg-[var(--sec)] w-8 h-8 rounded p-2 flex justify-center items-center">
                        <v-icon variant="outlined" color="primary" icon="mdi-poll"></v-icon>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-4 border border-gray-600 px-6 py-6 rounded bg-white max-h-fit">
                <div class="text-gray-900 text-xl font-semibold">Recent Transactions</div>
            </div>
        </div>
    </section>  
</template>

<script setup>
import AdvertisersLayout from './advertisersLayout.vue';

defineOptions({ layout: AdvertisersLayout });
</script>