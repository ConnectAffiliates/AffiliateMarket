<template>
  <div class="font-sans antialiased">
    <IndexNavbar />
    <main>
      <!-- Hero Section -->
      <div
        class="relative pt-24 pb-32 flex content-center items-center justify-center min-h-screen-75"
      >
        <div
          class="absolute top-0 w-full h-full bg-center bg-cover"
          style="
            background-image: url('https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1267&q=80');
          "
        >
          <span
            id="blackOverlay"
            class="w-full h-full absolute opacity-75 bg-gradient-to-b from-black to-gray-900"
          ></span>
        </div>
        <div class="container relative mx-auto">
          <div class="items-center flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
              <div class="pr-12">
                <h1 class="text-white font-bold text-5xl md:text-6xl mb-6 tracking-tight">
                  AI-Powered <span class="text-emerald-400">Affiliate Marketing</span> Platform
                </h1>
                <p class="mt-4 text-xl text-gray-200 leading-relaxed font-light">
                  Connect advertisers with affiliate marketers in a performance-based ecosystem. 
                  Create campaigns, track performance, and earn commissions automatically.
                </p>
                <div class="mt-10">
                  <Link
                    :href="route('register')"
                    class="bg-emerald-500 text-white active:bg-emerald-600 text-base font-medium px-8 py-4 rounded-lg shadow-lg hover:shadow-xl outline-none focus:outline-none mr-4 mb-4 ease-linear transition-all duration-150 hover:bg-emerald-600 transform hover:-translate-y-1"
                  >
                    Get Started
                  </Link>
                  <a
                    href="#features"
                    class="bg-transparent text-white border border-white active:bg-white/10 text-base font-medium px-8 py-4 rounded-lg shadow-lg hover:shadow-xl outline-none focus:outline-none mb-4 ease-linear transition-all duration-150 hover:bg-white/10 transform hover:-translate-y-1"
                  >
                    Learn More
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div
          class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden h-70-px"
          style="transform: translateZ(0);"
        >
          <svg
            class="absolute bottom-0 overflow-hidden"
            xmlns="http://www.w3.org/2000/svg"
            preserveAspectRatio="none"
            version="1.1"
            viewBox="0 0 2560 100"
            x="0"
            y="0"
          >
            <polygon
              class="text-gray-100 fill-current"
              points="2560 0 2560 100 0 100"
            ></polygon>
          </svg>
        </div>
      </div>

      <!-- Features Section -->
      <section id="features" class="pb-20 bg-gray-50 -mt-24">
        <div class="container mx-auto px-4">
          <div class="flex flex-wrap">
            <div class="lg:pt-12 pt-6 w-full md:w-4/12 px-4 text-center">
              <div
                class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
              >
                <div class="px-4 py-5 flex-auto">
                  <div
                    class="text-white p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-5 shadow-lg rounded-full bg-gradient-to-r from-red-500 to-red-600"
                  >
                    <i class="fas fa-award text-2xl"></i>
                  </div>
                  <h6 class="text-xl text-gray-800 font-semibold tracking-wide">Advertiser Portal</h6>
                  <p class="mt-2 mb-4 text-gray-600 leading-relaxed">
                    Create and manage advertising campaigns with an intuitive interface. 
                    Generate unique tracking links and define commission structures.
                  </p>
                </div>
              </div>
            </div>

            <div class="w-full md:w-4/12 px-4 text-center">
              <div
                class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
              >
                <div class="px-4 py-5 flex-auto">
                  <div
                    class="text-white p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-5 shadow-lg rounded-full bg-gradient-to-r from-blue-500 to-blue-600"
                  >
                  <i class="fa fa-retweet text-2xl" aria-hidden="true"></i>
                  </div>
                  <h6 class="text-xl text-gray-800 font-semibold tracking-wide">Affiliate Dashboard</h6>
                  <p class="mt-2 mb-4 text-gray-600 leading-relaxed">
                    Browse and select available deals with clear information on potential earnings. 
                    Get real-time analytics and detailed performance reports.
                  </p>
                </div>
              </div>
            </div>

            <div class="w-full md:w-4/12 px-4 text-center">
              <div
                class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
              >
                <div class="px-4 py-5 flex-auto">
                  <div
                    class="text-white p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-5 shadow-lg rounded-full bg-gradient-to-r from-green-500 to-green-600"
                  >
                  <i class="fas fa-chart-line text-2xl"></i>
                  </div>
                  <h6 class="text-xl text-gray-800 font-semibold tracking-wide">Performance Tracking</h6>
                  <p class="mt-2 mb-4 text-gray-600 leading-relaxed">
                    Monitor affiliate link performance across various networks with robust tracking mechanisms. 
                    Ensure transparent and accurate measurement of all metrics.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- How It Works Section -->
      <section class="pb-20 bg-white">
        <div class="container mx-auto px-4">
          <div class="flex flex-wrap items-center">
            <div class="w-full md:w-6/12 px-4 mr-auto ml-auto">
              <div class="justify-center flex flex-wrap relative">
                <div class="w-full lg:w-6/12 px-4">
                  <div class="mt-12 max-w-lg text-center mx-auto">
                    <h3 class="text-3xl mb-2 font-semibold leading-normal text-gray-800 tracking-wide">
                      How It Works
                    </h3>
                    <p class="text-lg font-light leading-relaxed mt-4 mb-4 text-gray-600">
                      Our platform connects advertisers with affiliate marketers in a seamless ecosystem.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="flex flex-wrap mt-12">
            <div class="w-full md:w-4/12 px-4 text-center">
              <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="px-4 py-5 flex-auto">
                  <div class="text-white p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-5 shadow-lg rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600">
                    <i class="fas fa-user-plus text-2xl"></i>
                  </div>
                  <h6 class="text-xl text-gray-800 font-semibold tracking-wide">1. Sign Up</h6>
                  <p class="mt-2 mb-4 text-gray-600 leading-relaxed">
                    Create your account as an advertiser or affiliate marketer to get started.
                  </p>
                </div>
              </div>
            </div>
            <div class="w-full md:w-4/12 px-4 text-center">
              <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="px-4 py-5 flex-auto">
                  <div class="text-white p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-5 shadow-lg rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600">
                    <i class="fas fa-link text-2xl"></i>
                  </div>
                  <h6 class="text-xl text-gray-800 font-semibold tracking-wide">2. Create Campaigns</h6>
                  <p class="mt-2 mb-4 text-gray-600 leading-relaxed">
                    Advertisers create campaigns and generate tracking links for affiliates to promote.
                  </p>
                </div>
              </div>
            </div>
            <div class="w-full md:w-4/12 px-4 text-center">
              <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="px-4 py-5 flex-auto">
                  <div class="text-white p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-5 shadow-lg rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                  </div>
                  <h6 class="text-xl text-gray-800 font-semibold tracking-wide">3. Earn Commissions</h6>
                  <p class="mt-2 mb-4 text-gray-600 leading-relaxed">
                    Affiliates promote links and earn commissions based on performance metrics.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Benefits Section -->
      <section class="pb-20 bg-gray-50">
        <div class="container mx-auto px-4">
          <div class="flex flex-wrap">
            <div class="w-full md:w-6/12 px-4 mr-auto ml-auto">
              <div class="justify-center flex flex-wrap relative">
                <div class="w-full lg:w-6/12 px-4">
                  <div class="mt-12 max-w-lg text-center mx-auto">
                    <h3 class="text-3xl mb-2 font-semibold leading-normal text-gray-800 tracking-wide">
                      Benefits
                    </h3>
                    <p class="text-lg font-light leading-relaxed mt-4 mb-4 text-gray-600">
                      Why choose our platform for your affiliate marketing needs?
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="flex flex-wrap mt-12">
            <div class="w-full md:w-6/12 px-4">
              <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="px-4 py-5 flex-auto">
                  <div class="flex items-center mb-4">
                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600 mr-4">
                      <i class="fas fa-shield-alt"></i>
                    </div>
                    <h6 class="text-xl text-gray-800 font-semibold tracking-wide">Security & Compliance</h6>
                  </div>
                  <p class="mt-2 mb-4 text-gray-600 leading-relaxed">
                    Protect user data and transaction details in compliance with applicable data privacy regulations.
                    Our platform incorporates measures to detect and prevent fraudulent activity.
                  </p>
                </div>
              </div>
            </div>
            <div class="w-full md:w-6/12 px-4">
              <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="px-4 py-5 flex-auto">
                  <div class="flex items-center mb-4">
                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600 mr-4">
                      <i class="fas fa-robot"></i>
                    </div>
                    <h6 class="text-xl text-gray-800 font-semibold tracking-wide">AI-Powered Optimization</h6>
                  </div>
                  <p class="mt-2 mb-4 text-gray-600 leading-relaxed">
                    Our platform uses AI to optimize performance tracking and matching between advertisers and affiliates.
                    Get better results with data-driven insights and recommendations.
                  </p>
                </div>
              </div>
            </div>
            <div class="w-full md:w-6/12 px-4">
              <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="px-4 py-5 flex-auto">
                  <div class="flex items-center mb-4">
                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600 mr-4">
                      <i class="fas fa-sync-alt"></i>
                    </div>
                    <h6 class="text-xl text-gray-800 font-semibold tracking-wide">Automated Rewards</h6>
                  </div>
                  <p class="mt-2 mb-4 text-gray-600 leading-relaxed">
                    Automatically calculate commissions based on verified performance data.
                    Facilitate secure and transparent payouts to affiliate marketers.
                  </p>
                </div>
              </div>
            </div>
            <div class="w-full md:w-6/12 px-4">
              <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="px-4 py-5 flex-auto">
                  <div class="flex items-center mb-4">
                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600 mr-4">
                      <i class="fas fa-expand-arrows-alt"></i>
                    </div>
                    <h6 class="text-xl text-gray-800 font-semibold tracking-wide">Scalability</h6>
                  </div>
                  <p class="mt-2 mb-4 text-gray-600 leading-relaxed">
                    Our platform is designed to accommodate a growing user base and increasing campaign volume.
                    Scale your affiliate marketing efforts without worrying about technical limitations.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="pb-20 bg-gradient-to-r from-emerald-600 to-emerald-800">
        <div class="container mx-auto px-4">
          <div class="flex flex-wrap items-center">
            <div class="w-full md:w-8/12 px-4 mr-auto ml-auto text-center">
              <h3 class="text-3xl mb-2 font-semibold leading-normal text-white tracking-wide">
                Ready to get started?
              </h3>
              <p class="text-lg font-light leading-relaxed mt-4 mb-4 text-white">
                Join our platform today and start growing your business with affiliate marketing.
              </p>
              <div class="mt-10">
                <Link
                  :href="route('register')"
                  class="bg-white text-emerald-600 active:bg-gray-100 text-base font-medium px-8 py-4 rounded-lg shadow-lg hover:shadow-xl outline-none focus:outline-none mr-4 mb-4 ease-linear transition-all duration-150 hover:bg-gray-50 transform hover:-translate-y-1"
                >
                  Create Account
                </Link>
                <Link
                  :href="route('login')"
                  class="bg-transparent text-white border border-white active:bg-emerald-700 text-base font-medium px-8 py-4 rounded-lg shadow-lg hover:shadow-xl outline-none focus:outline-none mb-4 ease-linear transition-all duration-150 hover:bg-emerald-700 transform hover:-translate-y-1"
                >
                  Sign In
                </Link>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <footer class="relative bg-gray-100 pt-8 pb-6">
      <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center md:justify-between justify-center">
          <div class="w-full md:w-6/12 px-4 mx-auto text-center">
            <div class="text-sm text-gray-600 py-1">
              © 2024 Affiliate Market. All rights reserved.
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import IndexNavbar from '../components/Navbars/IndexNavbar.vue'
import { Link } from '@inertiajs/vue3'
</script>
