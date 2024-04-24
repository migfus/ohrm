<script setup lang="ts">
import type { GTAuth } from '@/globalTypes'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import { ArrowRightStartOnRectangleIcon, Cog6ToothIcon, SquaresPlusIcon, TableCellsIcon, BellIcon } from '@heroicons/vue/24/outline'
import AppButton from '../form/AppButton.vue'

const page = usePage()

const auth = computed(() => page.props.auth as GTAuth)
</script>

<template>
  <div v-if="auth" class="flex">
    <button type="button" class="mr-2 rounded-full bg-brand-50 p-1 text-brand-600 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
      <span class="sr-only">View notifications</span>
      <BellIcon class="h-6 w-6" aria-hidden="true" />
    </button>
    <Menu as="div" class="relative ml-3">
      <div>
        <MenuButton class="flex rounded-full bg-brand-100 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
          <span class="sr-only">Open user menu</span>
          <img class="h-8 w-8 rounded-full" :src="auth.avatar" alt="" />
        </MenuButton>
      </div>
      <transition enter-active-class="transition ease-out duration-200" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
        <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">

          <div class="text-gray-400 ml-3 my-2 text-sm truncate">{{ auth.name }}</div>
          <div class="text-gray-400 ml-3 my-2 text-sm truncate">{{ auth.email }}</div>
          <MenuItem v-slot="{ active, close }">
            <Link @click="close" href="/dashboard" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
              <SquaresPlusIcon class="text-gray-500h-5 w-4 flex-shrink-0 sm:-ml-1 mr-2 inline mb-1" />
              Dashboard
            </Link>
          </MenuItem>

          <MenuItem v-slot="{ active, close }">
            <Link @click="close" href="/my-groups" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
              <TableCellsIcon class="text-gray-500h-5 w-4 flex-shrink-0 sm:-ml-1 mr-2 inline mb-1" />
              My Groups
            </Link>
          </MenuItem>


          <MenuItem v-slot="{ active, close }" class="align-middle">
            <Link @click="close" href="/account" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
              <Cog6ToothIcon class="text-gray-500h-5 w-4 flex-shrink-0 sm:-ml-1 mr-2 inline mb-1" />
              Account Settings
            </Link>
          </MenuItem>

          <MenuItem v-slot="{ active, close }" class="flex flex-row align-middle">
            <Link @click="close" href="/logout" method="post" as="button" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700 w-full']">
              <ArrowRightStartOnRectangleIcon class="text-gray-500h-5 w-4 flex-shrink-0 sm:-ml-1 mr-3 inline mb-1" />
              Sign out
            </Link>
          </MenuItem>

        </MenuItems>
      </transition>
    </Menu>
  </div>

  <div v-else>
    <Link href="/login">
      <AppButton color="brand">Sign-in</AppButton>
    </Link>
  </div>
</template>

