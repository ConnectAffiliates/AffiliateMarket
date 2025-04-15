<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Affiliate Dashboard',
        href: '/affiliate/dashboard',
    },
];
</script>

<template>
    <Head title="Affiliate Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="grid gap-4 md:grid-cols-3">
                <Card>
                    <CardHeader>
                        <CardTitle>Active Links</CardTitle>
                        <CardDescription>Your active affiliate links</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="text-3xl font-bold">0</div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Total Earnings</CardTitle>
                        <CardDescription>Your total earnings this month</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="text-3xl font-bold">$0.00</div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Conversion Rate</CardTitle>
                        <CardDescription>Average conversion rate</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="text-3xl font-bold">0%</div>
                    </CardContent>
                </Card>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>Available Campaigns</CardTitle>
                    <CardDescription>Campaigns you can promote</CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                        No campaigns available. Check back soon for new opportunities.
                    </div>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>Performance Analytics</CardTitle>
                    <CardDescription>Your promotion performance over time</CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="h-[300px] flex items-center justify-center text-sm text-gray-500 dark:text-gray-400">
                        Analytics will appear here once you start promoting campaigns
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template> 