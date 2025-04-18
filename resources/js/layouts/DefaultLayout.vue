<script setup lang="ts">
// Default layout for public pages


</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center">
        <a href="/" class="flex items-center">
          <img src="/images/byteforce-logo.jpg" alt="ByteForce Logo" class="h-10 w-auto" />
          <span class="ml-3 text-lg font-semibold text-gray-900">ByteForce</span>
        </a>
        <nav class="ml-auto">
          <div class="flex space-x-4">
            <a href="/" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600">Home</a>
            <a href="/about" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600">About</a>
            <a href="/auth" class="px-3 py-2 text-sm font-medium text-indigo-600 border border-indigo-500 rounded-md">Login</a>
          </div>
        </nav>
      </div>
    </header>
    
    <main>
      <slot></slot>
    </main>
    
    <footer class="bg-white border-t border-gray-200 mt-12 py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
          <div>
            <p class="text-sm text-gray-500">&copy; 2023 ByteForce. All rights reserved.</p>
          </div>
          <div class="flex space-x-6">
            <a href="/terms" class="text-sm text-gray-500 hover:text-gray-700">Terms</a>
            <a href="/privacy" class="text-sm text-gray-500 hover:text-gray-700">Privacy</a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template> 