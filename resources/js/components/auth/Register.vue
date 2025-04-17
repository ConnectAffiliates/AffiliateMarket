<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Create your account
        </h2>
      </div>
      <form class="mt-8 space-y-6" @submit.prevent="handleSubmit">
        <div class="rounded-md shadow-sm -space-y-px">
          <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
              <label for="first_name" class="sr-only">First Name</label>
              <input
                id="first_name"
                v-model="form.first_name"
                type="text"
                required
                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                placeholder="First Name"
              />
            </div>
            <div>
              <label for="last_name" class="sr-only">Last Name</label>
              <input
                id="last_name"
                v-model="form.last_name"
                type="text"
                required
                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                placeholder="Last Name"
              />
            </div>
          </div>

          <div class="mb-4">
            <label for="email" class="sr-only">Email address</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Email address"
            />
          </div>

          <div class="mb-4">
            <label for="phone" class="sr-only">Phone Number</label>
            <input
              id="phone"
              v-model="form.phone"
              type="tel"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Phone Number"
            />
          </div>

          <div class="mb-4">
            <label for="password" class="sr-only">Password</label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Password"
            />
          </div>

          <div class="mb-4">
            <label for="password_confirmation" class="sr-only">Confirm Password</label>
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Confirm Password"
            />
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Account Type</label>
            <div class="mt-2 space-y-4">
              <div class="flex items-center">
                <input
                  id="advertiser"
                  v-model="form.role"
                  type="radio"
                  value="advertiser"
                  class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                />
                <label for="advertiser" class="ml-3 block text-sm font-medium text-gray-700">
                  Advertiser (Business Owner)
                </label>
              </div>
              <div class="flex items-center">
                <input
                  id="affiliate"
                  v-model="form.role"
                  type="radio"
                  value="affiliate"
                  class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                />
                <label for="affiliate" class="ml-3 block text-sm font-medium text-gray-700">
                  Affiliate Marketer
                </label>
              </div>
            </div>
          </div>
        </div>

        <div v-if="errors.length > 0" class="rounded-md bg-red-50 p-4 mb-4">
          <div class="flex">
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">There were errors with your submission:</h3>
              <div class="mt-2 text-sm text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                  <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div>
          <button
            type="submit"
            :disabled="loading"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <svg
                v-if="!loading"
                class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
              >
                <path
                  fill-rule="evenodd"
                  d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                  clip-rule="evenodd"
                />
              </svg>
              <svg
                v-else
                class="animate-spin h-5 w-5 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
                ></circle>
                <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
              </svg>
            </span>
            {{ loading ? 'Creating account...' : 'Create account' }}
          </button>
        </div>

        <div class="text-sm text-center">
          <router-link
            to="/login"
            class="font-medium text-indigo-600 hover:text-indigo-500"
          >
            Already have an account? Sign in
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

export default {
  name: 'Register',
  setup() {
    const router = useRouter()
    const loading = ref(false)
    const errors = ref([])
    const form = ref({
      first_name: '',
      last_name: '',
      email: '',
      phone: '',
      password: '',
      password_confirmation: '',
      role: 'affiliate'
    })

    const handleSubmit = async () => {
      loading.value = true
      errors.value = []

      try {
        const response = await axios.post('/api/register', form.value)
        if (response.data.token) {
          localStorage.setItem('token', response.data.token)
          await router.push(form.value.role === 'advertiser' ? '/advertiser/dashboard' : '/affiliate/dashboard')
        }
      } catch (error) {
        if (error.response?.data?.errors) {
          errors.value = Object.values(error.response.data.errors).flat()
        } else {
          errors.value = ['An unexpected error occurred. Please try again.']
        }
      } finally {
        loading.value = false
      }
    }

    return {
      form,
      loading,
      errors,
      handleSubmit
    }
  }
}
</script> 