<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import DefaultLayout from '@/layouts/DefaultLayout.vue';
</script>

<template>
  <DefaultLayout>
    <Head title="Privacy Policy" />

    <div class="container mx-auto px-4 py-8">
      <h1 class="text-3xl font-bold mb-6">Privacy Policy</h1>
      
      <div class="prose max-w-none">
        <h2>1. Information We Collect</h2>
        <p>We collect information that you provide directly to us, including when you create an account, use our services, or communicate with us.</p>

        <h2>2. How We Use Your Information</h2>
        <p>We use the information we collect to provide, maintain, and improve our services, to develop new ones, and to protect our platform and our users.</p>

        <h2>3. Information Sharing and Disclosure</h2>
        <p>We do not share your personal information with third parties except as described in this privacy policy.</p>

        <h2>4. Data Security</h2>
        <p>We take reasonable measures to help protect your personal information from loss, theft, misuse, unauthorized access, disclosure, alteration, and destruction.</p>

        <h2>5. Your Rights</h2>
        <p>You have the right to access, correct, or delete your personal information. You can also object to or restrict certain processing of your information.</p>

        <h2>6. Changes to This Policy</h2>
        <p>We may update this privacy policy from time to time. We will notify you of any changes by posting the new privacy policy on this page.</p>
      </div>
    </div>
  </DefaultLayout>
</template> 