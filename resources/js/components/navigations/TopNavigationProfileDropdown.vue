<template>
  <!-- NOTE: AUTH -->
  <div v-if="auth" class="flex">
    <!-- NOTE MESSAGES -->
    <Menu as="div" class="relative mr-3 mt-1">
      <div>
        <MenuButton class="flex rounded-full bg-brand-100 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
          <span class="sr-only">View chats</span>
          <ChatBubbleOvalLeftIcon class="h-6 w-6 text-brand-600 bg-brand-50 rounded-full" aria-hidden="true" />
        </MenuButton>
      </div>
      <transition enter-active-class="transition ease-out duration-200" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
        <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">

          <div class="text-gray-400 ml-3 my-2 text-sm truncate">Chat Conversation</div>
          <MenuItem v-slot="{ active, close }">
            <Link
              @click="close"
              :href="route('dashboard.index')"
              :class="[active ? 'bg-gray-100' : '', 'block px-3 py-2 text-sm text-gray-700 truncate']"
            >
              <img class="h-35 w-5 rounded-full inline mr-1" :src="auth.avatar" alt="" />
              Hi can I join to your group
            </Link>
          </MenuItem>

          <MenuItem v-slot="{ active, close }">
            <Link
              @click="close"
              :href="route('dashboard.index')"
              :class="[active ? 'bg-gray-100' : '', 'block px-3 py-2 text-sm text-gray-700 truncate']"
            >
              <img class="h-35 w-5 rounded-full inline mr-1" :src="auth.avatar" alt="" />
              Where are we?
            </Link>
          </MenuItem>

          <MenuItem v-slot="{ active, close }">
            <Link
              @click="close"
              :href="route('dashboard.index')"
              :class="[active ? 'bg-gray-100' : '', 'block px-3 py-2 text-sm text-gray-700 truncate']"
            >
              <img class="h-35 w-5 rounded-full inline mr-1" :src="auth.avatar" alt="" />
              The chat is not fully tested yet
            </Link>
          </MenuItem>

          <MenuItem v-slot="{ active, close }">
            <Link
              @click="close"
              :href="route('dashboard.index')"
              :class="[active ? 'bg-gray-100' : '', 'block px-3 py-2 text-sm text-gray-700 truncate']"
            >
              <img class="h-35 w-5 rounded-full inline mr-1" :src="auth.avatar" alt="" />
              Hoping for good outcome
            </Link>
          </MenuItem>

          <MenuItem v-slot="{ active, close }">
            <Link
              @click="close"
              :href="route('dashboard.index')"
              :class="[active ? 'bg-gray-100' : '', 'block px-3 py-2 text-sm text-gray-700 truncate']"
            >
              <img class="h-35 w-5 rounded-full inline mr-1" :src="auth.avatar" alt="" />
              😅🙏🙏
            </Link>
          </MenuItem>

        </MenuItems>
      </transition>
    </Menu>

    <!-- NOTE NOTIFICATIONS -->
    <Menu as="div" class="relative mr-3 mt-1">
      <div>
        <MenuButton class="flex rounded-full bg-brand-100 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
          <span class="sr-only">View notifications</span>
          <BellIcon class="h-6 w-6 text-brand-600 bg-brand-50 rounded-full" aria-hidden="true" />
        </MenuButton>
      </div>
      <transition enter-active-class="transition ease-out duration-200" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
        <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">

          <div class="text-gray-400 ml-3 my-2 text-sm truncate">Notifications</div>
          <MenuItem v-slot="{ active, close }">
            <Link @click="close" :href="route('dashboard.my-groups.index')" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
              <SquaresPlusIcon class="text-gray-500h-5 w-4 flex-shrink-0 sm:-ml-1 mr-2 inline mb-1" />
              Group Notification 1
            </Link>
          </MenuItem>
          <MenuItem v-slot="{ active, close }">
            <Link @click="close" :href="route('dashboard.my-groups.index')" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
              <SquaresPlusIcon class="text-gray-500h-5 w-4 flex-shrink-0 sm:-ml-1 mr-2 inline mb-1" />
              Group Notification 2
            </Link>
          </MenuItem>

          <MenuItem v-slot="{ active, close }">
            <Link @click="close" :href="route('dashboard.my-groups.index')" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700 truncate']">
              <TableCellsIcon class="text-gray-500h-5 w-4 flex-shrink-0 sm:-ml-1 mr-2 inline mb-1" />
              +1 New user added
            </Link>
          </MenuItem>

          <MenuItem v-slot="{ active, close }">
            <Link @click="close" :href="route('dashboard.my-groups.index')" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700 truncate']">
              <TableCellsIcon class="text-gray-500h-5 w-4 flex-shrink-0 sm:-ml-1 mr-2 inline mb-1" />
              Groups has been updated
            </Link>
          </MenuItem>

        </MenuItems>
      </transition>
    </Menu>

    <!-- NOTE PROFILE -->
    <Menu as="div" class="relative">
      <MenuButton class="flex rounded-full bg-brand-100 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 w-8">
        <span class="sr-only">Open user menu</span>
        <img class="h-8 w-8 rounded-full" :src="auth.avatar" alt="Avatar" />
      </MenuButton>
      <transition enter-active-class="transition ease-out duration-200" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
        <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">

          <div class="text-gray-400 ml-3 my-2 text-sm truncate">{{ auth.name }}</div>
          <div class="text-gray-400 ml-3 my-2 text-sm truncate">{{ auth.email }}</div>
          <MenuItem v-slot="{ active, close }">
            <Link @click="close" :href="route('dashboard.my-groups.index')" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
              <SquaresPlusIcon class="text-gray-500h-5 w-4 flex-shrink-0 sm:-ml-1 mr-2 inline mb-1" />
              Dashboard
            </Link>
          </MenuItem>

          <MenuItem v-slot="{ active, close }">
            <Link
              @click="close"
              :href="route('dashboard.my-groups.index')"
              :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']"
            >
              <FolderPlusIcon class="text-gray-500h-5 w-4 flex-shrink-0 sm:-ml-1 mr-2 inline mb-1" />
              My Groups
            </Link>
          </MenuItem>

          <MenuItem v-slot="{ active, close }">
            <Link
              @click="close" :href="route('dashboard.my-groups.index')"
              :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']"
            >
              <FolderOpenIcon class="text-gray-500h-5 w-4 flex-shrink-0 sm:-ml-1 mr-2 inline mb-1" />
              Joined Groups
            </Link>
          </MenuItem>


          <MenuItem v-slot="{ active, close }" class="align-middle">
            <Link
              @click="close" :href="route('dashboard.account.index')"
              :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']"
            >
              <Cog6ToothIcon class="text-gray-500h-5 w-4 flex-shrink-0 sm:-ml-1 mr-2 inline mb-1" />
              Account Settings
            </Link>
          </MenuItem>

          <MenuItem v-slot="{ active, close }" class="flex flex-row align-middle">
            <Link
              @click="close" :href="route('logout')"
              method="post"
              as="button"
              :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700 w-full']"
            >
              <ArrowRightStartOnRectangleIcon class="text-gray-500h-5 w-4 flex-shrink-0 sm:-ml-1 mr-3 inline mb-1" />
              Sign out
            </Link>
          </MenuItem>

        </MenuItems>
      </transition>
    </Menu>
  </div>

  <!-- NOTE: GUEST -->
  <div v-else>
    <Link :href="route('login')">
      <AppButton color="brand">Sign-in</AppButton>
    </Link>
  </div>
</template>

<script setup lang="ts">
import type { Auth } from '@/globalTypes'
import { computed } from 'vue'

import { usePage } from '@inertiajs/vue3'
import { Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {
  ArrowRightStartOnRectangleIcon,
  Cog6ToothIcon,
  SquaresPlusIcon,
  TableCellsIcon,
  BellIcon,
  ChatBubbleOvalLeftIcon,
  FolderOpenIcon,
  FolderPlusIcon
} from '@heroicons/vue/24/outline'
import AppButton from '@/components/form/AppButton.vue'

const page = usePage()

const auth = computed(() => page.props.auth as Auth)
</script>
