<script setup lang="ts">
import { ref } from 'vue';
import AdvertiserLayout from '@/layouts/AdvertiserLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Save } from 'lucide-vue-next';

const settings = ref({
    company: {
        name: 'Acme Inc.',
        website: 'https://acme.com',
        email: 'contact@acme.com',
        phone: '+1 (555) 123-4567',
    },
    payments: {
        autoPayments: true,
        paymentThreshold: 100,
        paymentMethod: 'bank_transfer',
        bankName: 'Bank of America',
        accountNumber: '****1234',
        routingNumber: '****5678',
    },
    notifications: {
        emailNotifications: true,
        newAffiliateSignups: true,
        campaignUpdates: true,
        paymentConfirmations: true,
        weeklyReports: true,
    },
});
</script>

<template>
    <AdvertiserLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Settings</h2>
                <Button class="flex items-center gap-2">
                    <Save class="h-4 w-4" />
                    Save Changes
                </Button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <Tabs defaultValue="company" class="space-y-6">
                    <TabsList>
                        <TabsTrigger value="company">Company</TabsTrigger>
                        <TabsTrigger value="payments">Payments</TabsTrigger>
                        <TabsTrigger value="notifications">Notifications</TabsTrigger>
                    </TabsList>

                    <TabsContent value="company">
                        <Card>
                            <CardHeader>
                                <CardTitle>Company Information</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="grid gap-4">
                                    <div class="grid gap-2">
                                        <Label for="company-name">Company Name</Label>
                                        <Input id="company-name" v-model="settings.company.name" />
                                    </div>
                                    <div class="grid gap-2">
                                        <Label for="website">Website</Label>
                                        <Input id="website" v-model="settings.company.website" type="url" />
                                    </div>
                                    <div class="grid gap-2">
                                        <Label for="email">Email</Label>
                                        <Input id="email" v-model="settings.company.email" type="email" />
                                    </div>
                                    <div class="grid gap-2">
                                        <Label for="phone">Phone</Label>
                                        <Input id="phone" v-model="settings.company.phone" type="tel" />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <TabsContent value="payments">
                        <Card>
                            <CardHeader>
                                <CardTitle>Payment Settings</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="flex items-center space-x-2">
                                    <Switch id="auto-payments" v-model="settings.payments.autoPayments" />
                                    <Label for="auto-payments">Enable Automatic Payments</Label>
                                </div>
                                <div class="grid gap-4">
                                    <div class="grid gap-2">
                                        <Label for="payment-threshold">Payment Threshold ($)</Label>
                                        <Input
                                            id="payment-threshold"
                                            v-model="settings.payments.paymentThreshold"
                                            type="number"
                                            min="0"
                                        />
                                    </div>
                                    <div class="grid gap-2">
                                        <Label for="bank-name">Bank Name</Label>
                                        <Input id="bank-name" v-model="settings.payments.bankName" />
                                    </div>
                                    <div class="grid gap-2">
                                        <Label for="account-number">Account Number</Label>
                                        <Input id="account-number" v-model="settings.payments.accountNumber" type="password" />
                                    </div>
                                    <div class="grid gap-2">
                                        <Label for="routing-number">Routing Number</Label>
                                        <Input id="routing-number" v-model="settings.payments.routingNumber" type="password" />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <TabsContent value="notifications">
                        <Card>
                            <CardHeader>
                                <CardTitle>Notification Preferences</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="flex items-center space-x-2">
                                    <Switch id="email-notifications" v-model="settings.notifications.emailNotifications" />
                                    <Label for="email-notifications">Enable Email Notifications</Label>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex items-center space-x-2">
                                        <Switch id="new-affiliates" v-model="settings.notifications.newAffiliateSignups" />
                                        <Label for="new-affiliates">New Affiliate Sign-ups</Label>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <Switch id="campaign-updates" v-model="settings.notifications.campaignUpdates" />
                                        <Label for="campaign-updates">Campaign Updates</Label>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <Switch id="payment-confirmations" v-model="settings.notifications.paymentConfirmations" />
                                        <Label for="payment-confirmations">Payment Confirmations</Label>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <Switch id="weekly-reports" v-model="settings.notifications.weeklyReports" />
                                        <Label for="weekly-reports">Weekly Performance Reports</Label>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    </TabsContent>
                </Tabs>
            </div>
        </div>
    </AdvertiserLayout>
</template> 