<template>
  <div>
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog as="div" class="relative z-40 md:hidden" @close="sidebarOpen = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-600 bg-opacity-75 backdrop-blur-sm" />
        </TransitionChild>

        <div class="fixed inset-0 z-40 flex">
          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
            <DialogPanel class="relative flex w-full max-w-xs flex-1 flex-col bg-brand-700 pt-5 pb-4">
              <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                  <button type="button" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="sidebarOpen = false">
                    <span class="sr-only">Close sidebar</span>
                    <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                  </button>
                </div>
              </TransitionChild>
              <div class="flex flex-shrink-0 items-center h-14 px-4 mx-4 text-brand-700 rounded-2xl bg-brand-100 shadow">
                <TopNavigationLogo :logo :title/>
                <label class="text-sm font-semibold">{{ $props.title }}</label>
              </div>
              <div class="mt-5 h-0 flex-1 overflow-y-auto">
                <nav class="space-y-1 px-2">
                  <SideNavigationContent title="Dashboard" :data="CSidebarNavigation" v-model="sidebarOpen"/>
                  <SideNavigationContent title="Admin" :data="CAdminNavigation" v-model="sidebarOpen"/>
                  <SideNavigationContent title="Pages" :data="CTopNavigation" v-model="sidebarOpen"/>
              </nav>
              </div>
            </DialogPanel>
          </TransitionChild>
          <div class="w-14 flex-shrink-0" aria-hidden="true">
            <!-- Dummy element to force sidebar to shrink to fit close icon -->
          </div>
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- MARK: DESKTOP Static sidebar for desktop -->
    <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex min-h-0 flex-1 flex-col bg-brand-700">
        <Link href="/" class="flex h-12 flex-shrink-0 items-center bg-brand px-4 shadow cursor-pointer bg-brand-100 rounded-2xl m-2">
          <TopNavigationLogo :logo :title/>
          <label class="font-semibold text-xs cursor-pointer text-bg-700">{{ $props.title }}</label>
        </Link>
        <div class="flex flex-1 flex-col overflow-y-auto">
          <nav class="flex-1 space-y-1 px-2 py-4">
            <SideNavigationContent title="Dashboard" :data="CSidebarNavigation" v-model="sidebarOpen"/>
            <SideNavigationContent title="Admin" :data="CAdminNavigation" v-model="sidebarOpen"/>
            <SideNavigationContent title="Pages" :data="CTopNavigation" v-model="sidebarOpen"/>
          </nav>


        </div>
      </div>
    </div>
    <div class="flex flex-col md:pl-64">
      <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 bg-brand-50 shadow">
        <button type="button" class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-500 md:hidden" @click="sidebarOpen = true">
          <span class="sr-only">Open sidebar</span>
          <Bars3BottomLeftIcon class="h-6 w-6" aria-hidden="true" />
        </button>
        <div class="flex flex-1 justify-between px-4 max-w-7xl mx-auto">
          <div class="flex flex-1">
            <form class="flex w-full md:ml-0" action="#" method="GET">
              <label for="search-field" class="sr-only">Search</label>
              <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center">
                  <MagnifyingGlassIcon class="h-5 w-5" aria-hidden="true" />
                </div>
                <input id="search-field" class="bg-brand-50 block h-full w-full border-transparent py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 focus:border-transparent focus:placeholder-gray-400 focus:outline-none focus:ring-0 sm:text-sm" placeholder="Search" type="search" name="search" />
              </div>
            </form>
          </div>
          <div class="ml-4 flex items-center md:ml-6">
            <TopNavigationProfileDropdown />
          </div>
        </div>
      </div>

      <main class="flex-1">
        <div class="py-6 mx-4">
          <div class="max-w-7xl mx-auto">

            <slot></slot>

          </div>
        </div>
      </main>
    </div>


  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { CTopNavigation, CSidebarNavigation, CAdminNavigation } from '@/constants'
import SideNavigationContent from '@/components/navigation/SideNavigationContent.vue'

import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { Bars3BottomLeftIcon, XMarkIcon, MagnifyingGlassIcon} from '@heroicons/vue/24/outline'
import TopNavigationProfileDropdown from './TopNavigationProfileDropdown.vue'
import TopNavigationLogo from './TopNavigationLogo.vue'

const sidebarOpen = ref(false)

const $props = defineProps<{
  title: string
  logo: string
}>()
</script>
