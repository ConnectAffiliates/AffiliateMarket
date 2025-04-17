<script setup lang="ts">
import { ref } from 'vue';
import AdvertiserLayout from '@/layouts/AdvertiserLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Download, CreditCard } from 'lucide-vue-next';

interface Payout {
    id: number;
    date: string;
    affiliate: string;
    campaign: string;
    amount: number;
    status: 'completed' | 'pending' | 'processing' | 'failed';
    method: 'bank_transfer' | 'paypal' | 'mobile_money';
}

const payouts = ref<Payout[]>([
    {
        id: 1,
        date: '2024-03-15',
        affiliate: 'John Doe',
        campaign: 'Summer Sale 2024',
        amount: 120000,
        status: 'completed',
        method: 'mobile_money',
    },
    {
        id: 2,
        date: '2024-03-14',
        affiliate: 'Jane Smith',
        campaign: 'New Product Launch',
        amount: 85000,
        status: 'pending',
        method: 'bank_transfer',
    },
    {
        id: 3,
        date: '2024-03-10',
        affiliate: 'Daniel Mtui',
        campaign: 'Back to School Sale',
        amount: 65000,
        status: 'processing',
        method: 'paypal',
    },
    {
        id: 4,
        date: '2024-02-28',
        affiliate: 'Amina Said',
        campaign: 'Tech Gadgets Promo',
        amount: 95000,
        status: 'completed',
        method: 'mobile_money',
    },
]);

const getStatusColor = (status: string) => {
    switch (status) {
        case 'completed':
            return 'text-green-600 bg-green-100';
        case 'processing':
            return 'text-blue-600 bg-blue-100';
        case 'pending':
            return 'text-yellow-600 bg-yellow-100';
        case 'failed':
            return 'text-red-600 bg-red-100';
        default:
            return 'text-gray-600 bg-gray-100';
    }
};

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('en-TZ', {
        style: 'currency',
        currency: 'TZS',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount);
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const getMethodLabel = (method: string) => {
    switch (method) {
        case 'bank_transfer':
            return 'Bank Transfer';
        case 'paypal':
            return 'PayPal';
        case 'mobile_money':
            return 'Mobile Money';
        default:
            return method;
    }
};
</script>

<template>
    <AdvertiserLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Affiliate Payouts</h2>
                <Button class="flex items-center gap-2">
                    <CreditCard class="h-4 w-4" />
                    Create New Payout
                </Button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>Payout History</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Date</TableHead>
                                    <TableHead>Affiliate</TableHead>
                                    <TableHead>Campaign</TableHead>
                                    <TableHead>Amount</TableHead>
                                    <TableHead>Method</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead>Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="payout in payouts" :key="payout.id">
                                    <TableCell>{{ formatDate(payout.date) }}</TableCell>
                                    <TableCell>{{ payout.affiliate }}</TableCell>
                                    <TableCell>{{ payout.campaign }}</TableCell>
                                    <TableCell>{{ formatCurrency(payout.amount) }}</TableCell>
                                    <TableCell>{{ getMethodLabel(payout.method) }}</TableCell>
                                    <TableCell>
                                        <span :class="['px-2 py-1 rounded-full text-xs font-medium', getStatusColor(payout.status)]">
                                            {{ payout.status.charAt(0).toUpperCase() + payout.status.slice(1) }}
                                        </span>
                                    </TableCell>
                                    <TableCell>
                                        <Button variant="ghost" size="icon">
                                            <Download class="h-4 w-4" />
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AdvertiserLayout>
</template> 