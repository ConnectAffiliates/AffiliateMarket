<script setup lang="ts">
import { ref, computed } from 'vue';
import AdvertiserLayout from '@/layouts/AdvertiserLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { CheckCircle, XCircle, Clock, AlertCircle } from 'lucide-vue-next';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

interface Sale {
    id: number;
    date: string;
    affiliate: string;
    customer: string;
    campaign: string;
    amount: number;
    commission: number;
    status: 'pending' | 'approved' | 'rejected' | 'flagged';
    referral_code: string;
}

const sales = ref<Sale[]>([
    {
        id: 1,
        date: '2024-03-15',
        affiliate: 'John Doe',
        customer: 'Maria Johnson',
        campaign: 'Summer Sale 2024',
        amount: 120000,
        commission: 12000,
        status: 'pending',
        referral_code: 'SUMMER24JD'
    },
    {
        id: 2,
        date: '2024-03-14',
        affiliate: 'Jane Smith',
        customer: 'Alex Thompson',
        campaign: 'New Product Launch',
        amount: 85000,
        commission: 8500,
        status: 'pending',
        referral_code: 'NEWPRODJS'
    },
    {
        id: 3,
        date: '2024-03-10',
        affiliate: 'Daniel Mtui',
        customer: 'Sarah Wilson',
        campaign: 'Tech Gadgets Promo',
        amount: 150000,
        commission: 15000,
        status: 'approved',
        referral_code: 'TECHDM20'
    },
    {
        id: 4,
        date: '2024-03-08',
        affiliate: 'Amina Said',
        customer: 'David Brown',
        campaign: 'Back to School Sale',
        amount: 95000,
        commission: 9500,
        status: 'flagged',
        referral_code: 'SCHOOLAS'
    },
    {
        id: 5,
        date: '2024-02-28',
        affiliate: 'James Wilson',
        customer: 'Emily Davis',
        campaign: 'Home Essentials',
        amount: 75000,
        commission: 7500,
        status: 'rejected',
        referral_code: 'HOMEJW21'
    }
]);

const searchQuery = ref('');
const statusFilter = ref('all');

const filteredSales = computed(() => {
    let result = sales.value;
    
    // Apply search query
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        result = result.filter(sale => 
            sale.affiliate.toLowerCase().includes(query) || 
            sale.customer.toLowerCase().includes(query) ||
            sale.campaign.toLowerCase().includes(query) ||
            sale.referral_code.toLowerCase().includes(query)
        );
    }
    
    // Apply status filter
    if (statusFilter.value !== 'all') {
        result = result.filter(sale => sale.status === statusFilter.value);
    }
    
    return result;
});

const getStatusColor = (status: string) => {
    switch (status) {
        case 'approved':
            return 'text-green-600 bg-green-100';
        case 'pending':
            return 'text-yellow-600 bg-yellow-100';
        case 'rejected':
            return 'text-red-600 bg-red-100';
        case 'flagged':
            return 'text-orange-600 bg-orange-100';
        default:
            return 'text-gray-600 bg-gray-100';
    }
};

const getStatusIcon = (status: string) => {
    switch (status) {
        case 'approved':
            return CheckCircle;
        case 'pending':
            return Clock;
        case 'rejected':
            return XCircle;
        case 'flagged':
            return AlertCircle;
        default:
            return Clock;
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

const approveSale = (id: number) => {
    const sale = sales.value.find(s => s.id === id);
    if (sale) {
        sale.status = 'approved';
    }
};

const rejectSale = (id: number) => {
    const sale = sales.value.find(s => s.id === id);
    if (sale) {
        sale.status = 'rejected';
    }
};

const flagSale = (id: number) => {
    const sale = sales.value.find(s => s.id === id);
    if (sale) {
        sale.status = 'flagged';
    }
};
</script>

<template>
    <AdvertiserLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Verify Sales</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <div class="flex items-center justify-between">
                            <CardTitle>Sales Verification</CardTitle>
                            <div class="flex space-x-4">
                                <div>
                                    <Label htmlFor="search" class="sr-only">Search</Label>
                                    <Input
                                        id="search"
                                        v-model="searchQuery"
                                        placeholder="Search affiliate, customer, or campaign..."
                                        class="w-64"
                                    />
                                </div>
                                <div>
                                    <div class="flex space-x-2">
                                        <div class="flex items-center space-x-1">
                                            <input 
                                                type="radio" 
                                                id="all" 
                                                value="all" 
                                                v-model="statusFilter"
                                                class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" 
                                            />
                                            <Label htmlFor="all">All</Label>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <input 
                                                type="radio" 
                                                id="pending" 
                                                value="pending" 
                                                v-model="statusFilter"
                                                class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" 
                                            />
                                            <Label htmlFor="pending">Pending</Label>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <input 
                                                type="radio" 
                                                id="approved" 
                                                value="approved" 
                                                v-model="statusFilter"
                                                class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" 
                                            />
                                            <Label htmlFor="approved">Approved</Label>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <input 
                                                type="radio" 
                                                id="rejected" 
                                                value="rejected" 
                                                v-model="statusFilter"
                                                class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" 
                                            />
                                            <Label htmlFor="rejected">Rejected</Label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Date</TableHead>
                                    <TableHead>Affiliate</TableHead>
                                    <TableHead>Customer</TableHead>
                                    <TableHead>Campaign</TableHead>
                                    <TableHead>Referral Code</TableHead>
                                    <TableHead>Amount</TableHead>
                                    <TableHead>Commission</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead>Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-if="filteredSales.length === 0">
                                    <TableCell colspan="9" class="text-center py-4">
                                        No sales found matching your criteria
                                    </TableCell>
                                </TableRow>
                                <TableRow v-for="sale in filteredSales" :key="sale.id">
                                    <TableCell>{{ formatDate(sale.date) }}</TableCell>
                                    <TableCell>{{ sale.affiliate }}</TableCell>
                                    <TableCell>{{ sale.customer }}</TableCell>
                                    <TableCell>{{ sale.campaign }}</TableCell>
                                    <TableCell>{{ sale.referral_code }}</TableCell>
                                    <TableCell>{{ formatCurrency(sale.amount) }}</TableCell>
                                    <TableCell>{{ formatCurrency(sale.commission) }}</TableCell>
                                    <TableCell>
                                        <div class="flex items-center space-x-1">
                                            <component :is="getStatusIcon(sale.status)" class="h-4 w-4" :class="`text-${sale.status === 'approved' ? 'green' : sale.status === 'pending' ? 'yellow' : sale.status === 'flagged' ? 'orange' : 'red'}-600`" />
                                            <span :class="['px-2 py-1 rounded-full text-xs font-medium', getStatusColor(sale.status)]">
                                                {{ sale.status.charAt(0).toUpperCase() + sale.status.slice(1) }}
                                            </span>
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        <div class="flex space-x-1">
                                            <Button 
                                                v-if="sale.status === 'pending'" 
                                                variant="ghost" 
                                                size="icon"
                                                @click="approveSale(sale.id)"
                                                class="text-green-600 hover:text-green-800 hover:bg-green-100"
                                            >
                                                <CheckCircle class="h-4 w-4" />
                                            </Button>
                                            <Button 
                                                v-if="sale.status === 'pending'" 
                                                variant="ghost" 
                                                size="icon"
                                                @click="rejectSale(sale.id)"
                                                class="text-red-600 hover:text-red-800 hover:bg-red-100"
                                            >
                                                <XCircle class="h-4 w-4" />
                                            </Button>
                                            <Button 
                                                v-if="sale.status === 'pending'" 
                                                variant="ghost" 
                                                size="icon"
                                                @click="flagSale(sale.id)"
                                                class="text-orange-600 hover:text-orange-800 hover:bg-orange-100"
                                            >
                                                <AlertCircle class="h-4 w-4" />
                                            </Button>
                                        </div>
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