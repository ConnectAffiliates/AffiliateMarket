<script setup lang="ts">
import InputError from '@/components/InputError.vue'
import TextLink from '@/components/TextLink.vue'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import AuthSimpleLayout from '@/layouts/auth/AuthSimpleLayout.vue'
import { Head, useForm, Link } from '@inertiajs/vue3'
import { LoaderCircle } from 'lucide-vue-next'
import { route } from 'ziggy-js'
import { ref } from 'vue'

const form = useForm({
  first_name: '',
  last_name: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: false,
  role: 'affiliate', // Default role
})

const showPassword = ref(false)
const showPasswordConfirmation = ref(false)
const showSuccessMessage = ref(false)

const togglePasswordVisibility = (field: 'password' | 'password_confirmation') => {
  if (field === 'password') {
    showPassword.value = !showPassword.value
  } else if (field === 'password_confirmation') {
    showPasswordConfirmation.value = !showPasswordConfirmation.value
  }
}

const submit = () => {
  if (!form.terms) {
    form.setError('terms', 'You must agree to the terms and conditions')
    return
  }

  form.post(route('register'), {
    preserveScroll: true,
    onSuccess: () => {
      showSuccessMessage.value = true
      // Hide success message after 5 seconds
      setTimeout(() => {
        showSuccessMessage.value = false
      }, 5000)
    },
    onFinish: () => {
      form.reset('password', 'password_confirmation')
    },
  })
}
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Create your account
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Or
        <Link :href="route('login')" class="font-medium text-emerald-600 hover:text-emerald-500">
          sign in to your account
        </Link>
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow-xl sm:rounded-lg sm:px-10">
        <!-- Success Message -->
        <div v-if="showSuccessMessage" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-md">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <p class="text-sm font-medium text-green-800">
                Registration successful! Please check your email to verify your account.
              </p>
              <p class="mt-2 text-sm text-green-700">
                <Link :href="route('login')" class="font-medium underline hover:text-green-600">
                  Click here to login
                </Link>
              </p>
            </div>
          </div>
        </div>

        <form @submit.prevent="submit">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label for="first_name" class="block text-sm font-medium text-gray-700">
                First Name
              </label>
              <div class="mt-1">
                <input
                  id="first_name"
                  v-model="form.first_name"
                  type="text"
                  required
                  class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm text-gray-900"
                />
              </div>
              <div v-if="form.errors.first_name" class="mt-2 text-sm text-red-600">
                {{ form.errors.first_name }}
              </div>
            </div>

            <div>
              <label for="last_name" class="block text-sm font-medium text-gray-700">
                Last Name
              </label>
              <div class="mt-1">
                <input
                  id="last_name"
                  v-model="form.last_name"
                  type="text"
                  required
                  class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm text-gray-900"
                />
              </div>
              <div v-if="form.errors.last_name" class="mt-2 text-sm text-red-600">
                {{ form.errors.last_name }}
              </div>
            </div>
          </div>

          <div class="mt-6">
            <label for="email" class="block text-sm font-medium text-gray-700">
              Email address
            </label>
            <div class="mt-1">
              <input
                id="email"
                v-model="form.email"
                type="email"
                autocomplete="email"
                required
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm text-gray-900"
              />
            </div>
            <div v-if="form.errors.email" class="mt-2 text-sm text-red-600">
              {{ form.errors.email }}
            </div>
          </div>

          <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700">
              Account Type
            </label>
            <div class="mt-2 grid grid-cols-2 gap-4">
              <div>
                <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                  <input
                    type="radio"
                    v-model="form.role"
                    value="affiliate"
                    class="sr-only"
                    aria-labelledby="affiliate-label"
                  />
                  <span class="flex flex-1">
                    <span class="flex flex-col">
                      <span id="affiliate-label" class="block text-sm font-medium text-gray-900">
                        Affiliate
                      </span>
                      <span class="mt-1 flex items-center text-sm text-gray-500">
                        Promote products and earn commissions
                      </span>
                    </span>
                  </span>
                  <span class="pointer-events-none absolute -inset-px rounded-lg border-2" :class="form.role === 'affiliate' ? 'border-emerald-500' : 'border-transparent'"></span>
                </label>
              </div>

              <div>
                <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                  <input
                    type="radio"
                    v-model="form.role"
                    value="advertiser"
                    class="sr-only"
                    aria-labelledby="advertiser-label"
                  />
                  <span class="flex flex-1">
                    <span class="flex flex-col">
                      <span id="advertiser-label" class="block text-sm font-medium text-gray-900">
                        Advertiser
                      </span>
                      <span class="mt-1 flex items-center text-sm text-gray-500">
                        Create and manage advertising campaigns
                      </span>
                    </span>
                  </span>
                  <span class="pointer-events-none absolute -inset-px rounded-lg border-2" :class="form.role === 'advertiser' ? 'border-emerald-500' : 'border-transparent'"></span>
                </label>
              </div>
            </div>
            <div v-if="form.errors.role" class="mt-2 text-sm text-red-600">
              {{ form.errors.role }}
            </div>
          </div>

          <div class="mt-6">
            <label for="password" class="block text-sm font-medium text-gray-700">
              Password
            </label>
            <div class="mt-1 relative">
              <input
                id="password"
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'"
                autocomplete="new-password"
                required
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm text-gray-900"
              />
              <button 
                type="button" 
                @click="togglePasswordVisibility('password')"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-gray-500 hover:text-gray-700"
              >
                <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="h-5 w-5"></i>
              </button>
            </div>
            <div v-if="form.errors.password" class="mt-2 text-sm text-red-600">
              {{ form.errors.password }}
            </div>
          </div>

          <div class="mt-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
              Confirm Password
            </label>
            <div class="mt-1 relative">
              <input
                id="password_confirmation"
                v-model="form.password_confirmation"
                :type="showPasswordConfirmation ? 'text' : 'password'"
                autocomplete="new-password"
                required
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm text-gray-900"
              />
              <button 
                type="button" 
                @click="togglePasswordVisibility('password_confirmation')"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-gray-500 hover:text-gray-700"
              >
                <i :class="showPasswordConfirmation ? 'fas fa-eye-slash' : 'fas fa-eye'" class="h-5 w-5"></i>
              </button>
            </div>
            <div v-if="form.errors.password_confirmation" class="mt-2 text-sm text-red-600">
              {{ form.errors.password_confirmation }}
            </div>
          </div>

          <div class="mt-6">
            <div class="flex items-center">
              <input
                id="terms"
                v-model="form.terms"
                type="checkbox"
                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
              />
              <label for="terms" class="ml-2 block text-sm text-gray-900">
                I agree to the
                <Link :href="route('terms')" class="font-medium text-emerald-600 hover:text-emerald-500">
                  Terms
                </Link>
                and
                <Link :href="route('privacy')" class="font-medium text-emerald-600 hover:text-emerald-500">
                  Privacy Policy
                </Link>
              </label>
            </div>
            <div v-if="form.errors.terms" class="mt-2 text-sm text-red-600">
              {{ form.errors.terms }}
            </div>
          </div>

          <div class="mt-6">
            <button
              type="submit"
              :disabled="form.processing"
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
            >
              <LoaderCircle v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
              Create Account
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
