<script setup lang="ts">
import { ref } from 'vue'
import { CTopNavigation, CSidebarNavigation, CAdminNavigation } from '@/constants'
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import {
  Bars3BottomLeftIcon,
  XMarkIcon,
} from '@heroicons/vue/24/outline'
import { MagnifyingGlassIcon } from '@heroicons/vue/20/solid'
import TopNavigationProfileDropdown from './TopNavigationProfileDropdown.vue'
import TopNavigationLogo from './TopNavigationLogo.vue'

const sidebarOpen = ref(false)
</script>

<template>
  <div>
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog as="div" class="relative z-40 md:hidden" @close="sidebarOpen = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-600 bg-opacity-75" />
        </TransitionChild>

        <div class="fixed inset-0 z-40 flex">
          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
            <DialogPanel class="relative flex w-full max-w-xs flex-1 flex-col bg-brand-50 pt-5 pb-4">
              <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                  <button type="button" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="sidebarOpen = false">
                    <span class="sr-only">Close sidebar</span>
                    <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                  </button>
                </div>
              </TransitionChild>
              <div class="flex flex-shrink-0 items-center px-4">
                <TopNavigationLogo />
                <label class="text-sm font-semibold">Office of Human Resources Management</label>
              </div>
              <div class="mt-5 h-0 flex-1 overflow-y-auto">
                <nav class="space-y-1 px-2">
                  <label class="ml-2">Dashboard</label>
                  <Link v-for="item in CSidebarNavigation" :key="item.name" :href="item.href" :class="[item.href == $page.url ? 'bg-brand-100 text-brand-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']">
                    <component :is="item.icon" :class="[item.href == $page.url ? 'text-gray-500' : 'text-brand-400 group-hover:text-gray-500', 'mr-3 h-6 w-6']" aria-hidden="true" />
                    <div class="truncate">{{ item.name }}</div>
                  </Link>

                  <label class="ml-2 mt-2">Admin</label>
                  <Link v-for="item in CAdminNavigation" :key="item.name" :href="item.href" :class="[item.href == $page.url ? 'bg-brand-100 text-brand-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']">
                    <component :is="item.icon" :class="[item.href == $page.url ? 'text-gray-500' : 'text-brand-400 group-hover:text-gray-500', 'mr-3 h-6 w-6']" aria-hidden="true" />
                    <div class="truncate">{{ item.name }}</div>
                  </Link>

                  <label class="ml-2 mt-2">Pages</label>
                  <Link v-for="item in CTopNavigation" :key="item.name" :href="item.href" :class="[item.href == $page.url ? 'bg-brand-100 text-brand-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']">
                    <component :is="item.icon" :class="[item.href == $page.url ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 h-6 w-6']" aria-hidden="true" />
                    <div class="truncate">{{ item.name }}</div>
                  </Link>
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
      <div class="flex min-h-0 flex-1 flex-col bg-brand-50">
        <Link href="/" class="flex h-16 flex-shrink-0 items-center bg-brand px-4 shadow">
          <TopNavigationLogo />
          <lable class="font-semibold text-sm">Office of Human Resource Management</lable>
        </Link>
        <div class="flex flex-1 flex-col overflow-y-auto">
          <nav class="flex-1 space-y-1 px-2 py-4">
            <label class="ml-2">Dashboard</label>
            <Link v-for="item in CSidebarNavigation" :key="item.name" :href="item.href" :class="[item.href == $page.url ? 'bg-brand-100 text-brand-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']">
              <component :is="item.icon" :class="[item.href == $page.url ? 'text-gray-500' : 'text-brand-400 group-hover:text-gray-500', 'mr-3 h-6 w-6']" aria-hidden="true" />
              <div class="truncate">{{ item.name }}</div>
            </Link>

            <label class="ml-2 mt-2">Admin</label>
            <Link v-for="item in CAdminNavigation" :key="item.name" :href="item.href" :class="[item.href == $page.url ? 'bg-brand-100 text-brand-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']">
              <component :is="item.icon" :class="[item.href == $page.url ? 'text-gray-500' : 'text-brand-400 group-hover:text-gray-500', 'mr-3 h-6 w-6']" aria-hidden="true" />
              <div class="truncate">{{ item.name }}</div>
            </Link>

            <label class="ml-2 mt-2">Pages</label>
            <Link v-for="item in CTopNavigation" :key="item.name" :href="item.href" :class="[item.href == $page.url ? 'bg-brand-100 text-brand-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']">
              <component :is="item.icon" :class="[item.href == $page.url ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 h-6 w-6']" aria-hidden="true" />
              <div class="truncate">{{ item.name }}</div>
            </Link>
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
        <div class="py-6">
          <div class="mx-auto max-w-7xl">

            <slot></slot>

          </div>
        </div>
      </main>
    </div>
  </div>
</template>


