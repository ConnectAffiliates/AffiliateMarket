<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'
import { PageProps } from '@/types'
import { ref, computed, watch, onMounted } from 'vue'
import { toastSuccess, toastError } from '@/utils/toast'
import { router } from '@inertiajs/vue3'

// Define User interface
interface User {
  id: number;
  first_name: string;
  last_name: string;
  email: string;
  role: string;
  status: string;
  joined_at: string;
}

const props = defineProps<{
  auth: PageProps['auth'],
  errors: {},
  users?: User[],
  pagination?: {
    total: number,
    per_page: number,
    current_page: number,
    last_page: number
  }
}>()

// Sample data - in a real app, this would come from the backend
const users = ref<User[]>(props.users || [
  { id: 1, first_name: 'Jane', last_name: 'Cooper', email: 'jane.cooper@example.com', role: 'advertiser', status: 'active', joined_at: '2023-05-15' },
  { id: 2, first_name: 'Cody', last_name: 'Fisher', email: 'cody.fisher@example.com', role: 'affiliate', status: 'active', joined_at: '2023-05-10' },
  { id: 3, first_name: 'Esther', last_name: 'Howard', email: 'esther.howard@example.com', role: 'affiliate', status: 'pending', joined_at: '2023-05-08' },
  { id: 4, first_name: 'Jenny', last_name: 'Wilson', email: 'jenny.wilson@example.com', role: 'advertiser', status: 'active', joined_at: '2023-05-05' },
  { id: 5, first_name: 'Kristin', last_name: 'Watson', email: 'kristin.watson@example.com', role: 'affiliate', status: 'pending', joined_at: '2023-05-03' },
  { id: 6, first_name: 'Cameron', last_name: 'Williamson', email: 'cameron.williamson@example.com', role: 'admin', status: 'active', joined_at: '2023-04-20' },
  { id: 7, first_name: 'Brooklyn', last_name: 'Simmons', email: 'brooklyn.simmons@example.com', role: 'affiliate', status: 'active', joined_at: '2023-04-18' },
  { id: 8, first_name: 'Leslie', last_name: 'Alexander', email: 'leslie.alexander@example.com', role: 'advertiser', status: 'inactive', joined_at: '2023-04-15' },
  { id: 9, first_name: 'Marvin', last_name: 'McKinney', email: 'marvin.mckinney@example.com', role: 'affiliate', status: 'active', joined_at: '2023-04-12' },
  { id: 10, first_name: 'Wade', last_name: 'Warren', email: 'wade.warren@example.com', role: 'advertiser', status: 'active', joined_at: '2023-04-10' }
])

// Filters and pagination
const filters = ref({
  search: '',
  role: 'all',
  status: 'all'
})

const pagination = ref(props.pagination || {
  total: users.value.length,
  per_page: 10,
  current_page: 1,
  last_page: Math.ceil(users.value.length / 10)
})

const selectedUser = ref<User | null>(null)
const userFormMode = ref('') // 'create', 'edit'
const userForm = ref({
  first_name: '',
  last_name: '',
  email: '',
  role: 'affiliate',
  status: 'active',
  password: '',
  password_confirmation: ''
})

// Available roles and statuses
const roles = [
  { value: 'admin', label: 'Admin' },
  { value: 'advertiser', label: 'Advertiser' },
  { value: 'affiliate', label: 'Affiliate' }
]

const statuses = [
  { value: 'active', label: 'Active' },
  { value: 'pending', label: 'Pending' },
  { value: 'inactive', label: 'Inactive' }
]

// Filtered users
const filteredUsers = computed(() => {
  return users.value.filter(user => {
    // Role filter
    if (filters.value.role !== 'all' && user.role !== filters.value.role) {
      return false
    }
    
    // Status filter
    if (filters.value.status !== 'all' && user.status !== filters.value.status) {
      return false
    }
    
    // Search
    if (filters.value.search) {
      const query = filters.value.search.toLowerCase()
      const fullName = `${user.first_name} ${user.last_name}`.toLowerCase()
      return fullName.includes(query) || 
             user.email.toLowerCase().includes(query) ||
             user.role.toLowerCase().includes(query)
    }
    
    return true
  })
})

// Paginated users
const paginatedUsers = computed(() => {
  const start = (pagination.value.current_page - 1) * pagination.value.per_page
  const end = start + pagination.value.per_page
  return filteredUsers.value.slice(start, end)
})

// Reset pagination when filters change
watch(filters, () => {
  pagination.value.current_page = 1
})

// Get page numbers for pagination control
const pages = computed(() => {
  pagination.value.last_page = Math.ceil(filteredUsers.value.length / pagination.value.per_page)
  pagination.value.total = filteredUsers.value.length
  
  if (pagination.value.last_page <= 7) {
    return Array.from({length: pagination.value.last_page}, (_, i) => i + 1)
  }
  
  const currentPage = pagination.value.current_page
  
  if (currentPage <= 4) {
    return [1, 2, 3, 4, 5, '...', pagination.value.last_page]
  }
  
  if (currentPage >= pagination.value.last_page - 3) {
    return [1, '...', pagination.value.last_page - 4, pagination.value.last_page - 3, pagination.value.last_page - 2, pagination.value.last_page - 1, pagination.value.last_page]
  }
  
  return [1, '...', currentPage - 1, currentPage, currentPage + 1, '...', pagination.value.last_page]
})

// User form modal
const isFormModalOpen = ref(false)

const openCreateUserModal = () => {
  userFormMode.value = 'create'
  userForm.value = {
    first_name: '',
    last_name: '',
    email: '',
    role: 'affiliate',
    status: 'active',
    password: '',
    password_confirmation: ''
  }
  isFormModalOpen.value = true
}

const openEditUserModal = (user: User) => {
  userFormMode.value = 'edit'
  userForm.value = {
    first_name: user.first_name,
    last_name: user.last_name,
    email: user.email,
    role: user.role,
    status: user.status,
    password: '',
    password_confirmation: ''
  }
  selectedUser.value = user
  isFormModalOpen.value = true
}

const submitUserForm = () => {
  // In a real app, this would submit to the backend
  try {
    if (userFormMode.value === 'create') {
      // Create user
      const newUser: User = {
        id: users.value.length + 1,
        ...userForm.value,
        joined_at: new Date().toISOString().split('T')[0]
      }
      users.value.unshift(newUser)
      toastSuccess('User created successfully!')
    } else if (selectedUser.value !== null) {
      // Update user
      const userIndex = users.value.findIndex(u => u.id === selectedUser.value!.id)
      if (userIndex !== -1) {
        users.value[userIndex] = {
          ...users.value[userIndex],
          first_name: userForm.value.first_name,
          last_name: userForm.value.last_name,
          email: userForm.value.email,
          role: userForm.value.role,
          status: userForm.value.status
        }
        toastSuccess('User updated successfully!')
      }
    }
    
    isFormModalOpen.value = false
  } catch (error) {
    toastError('An error occurred. Please try again.')
  }
}

// User details modal
const isDetailsModalOpen = ref(false)

const viewUserDetails = (user: User) => {
  selectedUser.value = user
  isDetailsModalOpen.value = true
}

// Delete user modal
const isDeleteModalOpen = ref(false)

const openDeleteUserModal = (user: User) => {
  selectedUser.value = user
  isDeleteModalOpen.value = true
}

const deleteUser = () => {
  // In a real app, this would call the API
  try {
    if (selectedUser.value !== null) {
      users.value = users.value.filter(u => u.id !== selectedUser.value!.id)
      isDeleteModalOpen.value = false
      toastSuccess('User deleted successfully!')
    }
  } catch (error) {
    toastError('An error occurred. Please try again.')
  }
}

// In a real app, this would load data from backend
onMounted(() => {
  // Fetch users from the server
  // Example: router.get('/admin/users', {})
})
</script>

<template>
  <Head title="User Management" />

  <AuthenticatedLayout>
    <template #header>
      <div class="px-4 sm:px-0 flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Management
          </h2>
          <p class="mt-1 text-sm text-gray-600">Manage users, roles and permissions</p>
        </div>
        <button 
          @click="openCreateUserModal"
          class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Add User
        </button>
      </div>
    </template>

    <div class="py-6 sm:py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 mb-6">
          <div class="p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between space-y-4 sm:space-y-0">
            <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
              <!-- Role Filter -->
              <div>
                <label for="role-filter" class="sr-only">Filter by role</label>
                <select 
                  id="role-filter" 
                  v-model="filters.role"
                  class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                >
                  <option value="all">All Roles</option>
                  <option value="admin">Admin</option>
                  <option value="advertiser">Advertiser</option>
                  <option value="affiliate">Affiliate</option>
                </select>
              </div>
              
              <!-- Status Filter -->
              <div>
                <label for="status-filter" class="sr-only">Filter by status</label>
                <select 
                  id="status-filter" 
                  v-model="filters.status"
                  class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                >
                  <option value="all">All Statuses</option>
                  <option value="active">Active</option>
                  <option value="pending">Pending</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
            </div>
            
            <!-- Search -->
            <div class="relative w-full sm:w-64">
              <input
                v-model="filters.search"
                type="text"
                placeholder="Search users..."
                class="w-full pr-10 pl-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              />
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Users Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="user in paginatedUsers" :key="user.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                        <span class="text-indigo-600 font-medium">{{ user.first_name.charAt(0) }}{{ user.last_name.charAt(0) }}</span>
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ user.first_name }} {{ user.last_name }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">{{ user.email }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full"
                          :class="{
                            'bg-purple-100 text-purple-800': user.role === 'admin',
                            'bg-indigo-100 text-indigo-800': user.role === 'advertiser',
                            'bg-green-100 text-green-800': user.role === 'affiliate'
                          }">
                      {{ user.role.charAt(0).toUpperCase() + user.role.slice(1) }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full"
                          :class="{
                            'bg-green-100 text-green-800': user.status === 'active',
                            'bg-yellow-100 text-yellow-800': user.status === 'pending',
                            'bg-red-100 text-red-800': user.status === 'inactive'
                          }">
                      {{ user.status.charAt(0).toUpperCase() + user.status.slice(1) }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ user.joined_at }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button 
                      @click="viewUserDetails(user)" 
                      class="text-indigo-600 hover:text-indigo-900 mr-3">
                      View
                    </button>
                    <button 
                      @click="openEditUserModal(user)" 
                      class="text-blue-600 hover:text-blue-900 mr-3">
                      Edit
                    </button>
                    <button 
                      @click="openDeleteUserModal(user)" 
                      class="text-red-600 hover:text-red-900">
                      Delete
                    </button>
                  </td>
                </tr>
                
                <!-- Empty state -->
                <tr v-if="paginatedUsers.length === 0">
                  <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                    No users found matching your search criteria.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          
          <!-- Pagination -->
          <div class="px-4 py-3 border-t border-gray-200 sm:px-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="text-sm text-gray-700">
              Showing <span class="font-medium">{{ paginatedUsers.length }}</span> of <span class="font-medium">{{ pagination.total }}</span> users
            </div>
            <div class="mt-3 sm:mt-0 flex justify-center sm:justify-end">
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <button
                  @click="pagination.current_page--"
                  :disabled="pagination.current_page === 1"
                  class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                  :class="{ 'opacity-50 cursor-not-allowed': pagination.current_page === 1 }"
                >
                  <span class="sr-only">Previous</span>
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                </button>
                <button
                  v-for="(page, index) in pages"
                  :key="index"
                  @click="page !== '...' ? pagination.current_page = Number(page) : null"
                  class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium"
                  :class="page === pagination.current_page ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'text-gray-500 hover:bg-gray-50'"
                >
                  {{ page }}
                </button>
                <button
                  @click="pagination.current_page++"
                  :disabled="pagination.current_page === pagination.last_page"
                  class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                  :class="{ 'opacity-50 cursor-not-allowed': pagination.current_page === pagination.last_page }"
                >
                  <span class="sr-only">Next</span>
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                  </svg>
                </button>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- User Form Modal (Create/Edit) -->
    <div v-if="isFormModalOpen" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg shadow-xl overflow-hidden max-w-lg w-full">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
          <h3 class="text-lg font-medium text-gray-900">
            {{ userFormMode === 'create' ? 'Add New User' : 'Edit User' }}
          </h3>
          <button @click="isFormModalOpen = false" class="text-gray-400 hover:text-gray-500">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        
        <div class="px-6 py-4">
          <form @submit.prevent="submitUserForm">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
              <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                <input 
                  type="text" 
                  id="first_name" 
                  v-model="userForm.first_name" 
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  required
                />
              </div>
              
              <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input 
                  type="text" 
                  id="last_name" 
                  v-model="userForm.last_name" 
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  required
                />
              </div>
              
              <div class="sm:col-span-2">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input 
                  type="email" 
                  id="email" 
                  v-model="userForm.email" 
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  required
                />
              </div>
              
              <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select 
                  id="role" 
                  v-model="userForm.role" 
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                  <option v-for="role in roles" :key="role.value" :value="role.value">
                    {{ role.label }}
                  </option>
                </select>
              </div>
              
              <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select 
                  id="status" 
                  v-model="userForm.status" 
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                  <option v-for="status in statuses" :key="status.value" :value="status.value">
                    {{ status.label }}
                  </option>
                </select>
              </div>
              
              <div v-if="userFormMode === 'create'" class="sm:col-span-2">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input 
                  type="password" 
                  id="password" 
                  v-model="userForm.password" 
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  required
                />
              </div>
              
              <div v-if="userFormMode === 'create'" class="sm:col-span-2">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input 
                  type="password" 
                  id="password_confirmation" 
                  v-model="userForm.password_confirmation" 
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  required
                />
              </div>
            </div>
            
            <div class="mt-6 flex justify-end">
              <button 
                type="button" 
                class="mr-3 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                @click="isFormModalOpen = false"
              >
                Cancel
              </button>
              <button 
                type="submit" 
                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                {{ userFormMode === 'create' ? 'Create User' : 'Save Changes' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <!-- User Details Modal -->
    <div v-if="isDetailsModalOpen && selectedUser" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg shadow-xl overflow-hidden max-w-lg w-full">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
          <h3 class="text-lg font-medium text-gray-900">User Details</h3>
          <button @click="isDetailsModalOpen = false" class="text-gray-400 hover:text-gray-500">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        
        <div class="px-6 py-4">
          <div class="flex items-center mb-6">
            <div class="h-20 w-20 rounded-full bg-indigo-100 flex items-center justify-center">
              <span class="text-2xl text-indigo-600 font-medium">{{ selectedUser?.first_name.charAt(0) }}{{ selectedUser?.last_name.charAt(0) }}</span>
            </div>
            <div class="ml-6">
              <h3 class="text-xl font-medium text-gray-900">{{ selectedUser?.first_name }} {{ selectedUser?.last_name }}</h3>
              <p class="text-sm text-gray-500">{{ selectedUser?.email }}</p>
              <div class="mt-2">
                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full"
                      :class="{
                        'bg-purple-100 text-purple-800': selectedUser?.role === 'admin',
                        'bg-indigo-100 text-indigo-800': selectedUser?.role === 'advertiser',
                        'bg-green-100 text-green-800': selectedUser?.role === 'affiliate'
                      }">
                  {{ selectedUser?.role.charAt(0).toUpperCase() + selectedUser?.role.slice(1) }}
                </span>
                <span class="ml-2 px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full"
                      :class="{
                        'bg-green-100 text-green-800': selectedUser?.status === 'active',
                        'bg-yellow-100 text-yellow-800': selectedUser?.status === 'pending',
                        'bg-red-100 text-red-800': selectedUser?.status === 'inactive'
                      }">
                  {{ selectedUser?.status.charAt(0).toUpperCase() + selectedUser?.status.slice(1) }}
                </span>
              </div>
            </div>
          </div>
          
          <div class="border-t border-gray-200 pt-4">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <p class="text-sm text-gray-500">Joined Date</p>
                <p class="mt-1 text-sm font-medium text-gray-900">{{ selectedUser?.joined_at }}</p>
              </div>
              <div>
                <p class="text-sm text-gray-500">User ID</p>
                <p class="mt-1 text-sm font-medium text-gray-900">#{{ selectedUser?.id }}</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end">
          <button 
            type="button" 
            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            @click="isDetailsModalOpen = false"
          >
            Close
          </button>
        </div>
      </div>
    </div>
    
    <!-- Delete User Confirmation Modal -->
    <div v-if="isDeleteModalOpen && selectedUser" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg shadow-xl overflow-hidden max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Confirm Delete</h3>
        </div>
        
        <div class="px-6 py-4">
          <p class="text-sm text-gray-500">
            Are you sure you want to delete the user <strong>{{ selectedUser?.first_name }} {{ selectedUser?.last_name }}</strong>? This action cannot be undone.
          </p>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end">
          <button 
            type="button" 
            class="mr-3 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            @click="isDeleteModalOpen = false"
          >
            Cancel
          </button>
          <button 
            type="button" 
            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
            @click="deleteUser"
          >
            Delete
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template> 