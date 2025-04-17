<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Download, CreditCard } from 'lucide-vue-next';

interface Payment {
    id: number;
    date: string;
    affiliate: string;
    campaign: string;
    amount: number;
    status: 'completed' | 'pending' | 'failed';
    method: 'bank_transfer' | 'paypal' | 'stripe';
}

const payments = ref<Payment[]>([
    {
        id: 1,
        date: '2024-03-15',
        affiliate: 'John Doe',
        campaign: 'Summer Sale 2024',
        amount: 1200,
        status: 'completed',
        method: 'paypal',
    },
    {
        id: 2,
        date: '2024-03-14',
        affiliate: 'Jane Smith',
        campaign: 'New Product Launch',
        amount: 850,
        status: 'pending',
        method: 'bank_transfer',
    },
]);

const getStatusColor = (status: string) => {
    switch (status) {
        case 'completed':
            return 'text-green-600 bg-green-100';
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
        case 'stripe':
            return 'Stripe';
        default:
            return method;
    }
};
</script>

<template>
    <AppLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Payments</h2>
                <Button class="flex items-center gap-2">
                    <CreditCard class="h-4 w-4" />
                    Make Payment
                </Button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>Payment History</CardTitle>
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
                                <TableRow v-for="payment in payments" :key="payment.id">
                                    <TableCell>{{ formatDate(payment.date) }}</TableCell>
                                    <TableCell>{{ payment.affiliate }}</TableCell>
                                    <TableCell>{{ payment.campaign }}</TableCell>
                                    <TableCell>{{ formatCurrency(payment.amount) }}</TableCell>
                                    <TableCell>{{ getMethodLabel(payment.method) }}</TableCell>
                                    <TableCell>
                                        <span :class="['px-2 py-1 rounded-full text-xs font-medium', getStatusColor(payment.status)]">
                                            {{ payment.status.charAt(0).toUpperCase() + payment.status.slice(1) }}
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
    </AppLayout>
</template> 