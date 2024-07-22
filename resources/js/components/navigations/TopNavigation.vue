<template>
  <!-- <TopBanner /> -->
  <Disclosure as="nav" class="bg-brand-50 shadow z-50" v-slot="{ open }">
    <!-- NOTE: MOBILE VIEW -->
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 justify-between">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Mobile menu button -->
          <DisclosureButton class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-500">
            <span class="sr-only">Open main menu</span>
            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
          </DisclosureButton>
        </div>
        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
          <Link href="/" class="flex flex-shrink-0 items-center">
            <TopNavigationLogo :title :logo/>
          </Link>
          <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <TopNavigationsDesktop
              v-for="row in CTopNavigation"
              :key="row.name"
              :href="row.href"
              :active="row.active"
              :icon="row.icon"
              :name="row.name"
              :components="row.components"
            />
          </div>


        </div>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0 space-x-4">
          <!-- <SearchBar/> -->



          <!-- Profile dropdown -->
          <TopNavigationProfileDropdown />
        </div>
      </div>
    </div>
    <!-- NOTE: DESKTOP VIEW -->
    <DisclosurePanel class="sm:hidden">
      <div class="space-y-1 pt-2 pb-4">
        <TopNavigationsMobile
          v-for="row in CTopNavigation"
          :key="row.name"
          :href="row.href"
          :active="row.active"
          :name="row.name"
          :icon="row.icon"
          :components="row.components"
        />

      </div>
    </DisclosurePanel>
  </Disclosure>

  <!-- NOTE: CONTENTS -->
  <slot></slot>
</template>

<script setup lang="ts">
import { CTopNavigation } from '@/constants'

import { Disclosure, DisclosureButton, DisclosurePanel, } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon, } from '@heroicons/vue/24/outline'
import TopNavigationsDesktop from './TopNavigationsDesktop.vue'
import TopNavigationsMobile from './TopNavigationsMobile.vue'
import TopNavigationLogo from './TopNavigationLogo.vue'
import TopNavigationProfileDropdown from './TopNavigationProfileDropdown.vue'

defineProps<{
  title: string
  logo: string
}>()
</script>
