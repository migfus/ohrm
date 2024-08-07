<template>
  <div>
    <TransitionRoot as="template" :show="sidebar_open">
      <Dialog as="div" class="relative z-40 md:hidden" @close="sidebar_open = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-600 bg-opacity-75" />
        </TransitionChild>

        <div class="fixed inset-0 z-40 flex">
          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
            <DialogPanel class="relative flex w-full max-w-xs flex-1 flex-col bg-white pt-5 pb-4">
              <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                <div class="absolute top-0 right-0 -mr-14 p-1">
                  <button type="button" class="flex h-12 w-12 items-center justify-center rounded-full focus:bg-gray-600 focus:outline-none" @click="sidebar_open = false">
                    <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                    <span class="sr-only">Close sidebar</span>
                  </button>
                </div>
              </TransitionChild>
              <div class="flex flex-shrink-0 items-center px-4">
                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=purple&shade=600" alt="Easywire" />
              </div>
              <div class="mt-5 h-0 flex-1 overflow-y-auto">
                <nav class="flex h-full flex-col">
                  <div class="space-y-1">
                    <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-purple-50 border-purple-600 text-purple-600' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group border-l-4 py-2 px-3 flex items-center text-base font-medium']" :aria-current="item.current ? 'page' : undefined">
                      <component :is="item.icon" :class="[item.current ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-4 flex-shrink-0 h-6 w-6']" aria-hidden="true" />
                      {{ item.name }}
                    </a>
                  </div>
                  <div class="mt-auto space-y-1 pt-10">
                    <a v-for="item in secondaryNavigation" :key="item.name" :href="item.href" class="group flex items-center border-l-4 border-transparent py-2 px-3 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                      <component :is="item.icon" class="mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                      {{ item.name }}
                    </a>
                  </div>
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

    <!-- Static sidebar for desktop -->
    <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <nav class="flex flex-grow flex-col overflow-y-auto border-r border-gray-200 bg-gray-50 pt-5 pb-4">
        <div class="flex flex-shrink-0 items-center px-4">
          <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=purple&shade=600" alt="Easywire" />
        </div>
        <div class="mt-5 flex-grow">
          <div class="space-y-1">
            <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-purple-50 border-purple-600 text-purple-600' : 'border-transparent text-gray-600 hover:text-gray-900 hover:bg-gray-50', 'group border-l-4 py-2 px-3 flex items-center text-sm font-medium']">
              <component :is="item.icon" :class="[item.current ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']" aria-hidden="true" />
              {{ item.name }}
            </a>
          </div>
        </div>
        <div class="block w-full flex-shrink-0">
          <a v-for="item in secondaryNavigation" :key="item.name" :href="item.href" class="group flex items-center border-l-4 border-transparent py-2 px-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
            <component :is="item.icon" class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
            {{ item.name }}
          </a>
        </div>
      </nav>
    </div>

    <!-- Content area -->
    <div class="md:pl-64">
      <div class="mx-auto flex max-w-4xl flex-col md:px-8 xl:px-0">
        <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 border-b border-gray-200 bg-white">
          <button type="button" class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500 md:hidden" @click="sidebar_open = true">
            <span class="sr-only">Open sidebar</span>
            <Bars3BottomLeftIcon class="h-6 w-6" aria-hidden="true" />
          </button>
          <div class="flex flex-1 justify-between px-4 md:px-0">
            <div class="flex flex-1">
              <form class="flex w-full md:ml-0" action="#" method="GET">
                <label for="mobile-search-field" class="sr-only">Search</label>
                <label for="desktop-search-field" class="sr-only">Search</label>
                <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                  <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center">
                    <MagnifyingGlassIcon class="h-5 w-5 flex-shrink-0" aria-hidden="true" />
                  </div>
                  <input name="mobile-search-field" id="mobile-search-field" class="h-full w-full border-transparent py-2 pl-8 pr-3 text-base text-gray-900 placeholder-gray-500 focus:border-transparent focus:placeholder-gray-400 focus:outline-none focus:ring-0 sm:hidden" placeholder="Search" type="search" />
                  <input name="desktop-search-field" id="desktop-search-field" class="hidden h-full w-full border-transparent py-2 pl-8 pr-3 text-sm text-gray-900 placeholder-gray-500 focus:border-transparent focus:placeholder-gray-400 focus:outline-none focus:ring-0 sm:block" placeholder="Search jobs, applicants, and more" type="search" />
                </div>
              </form>
            </div>
            <div class="ml-4 flex items-center md:ml-6">
              <button type="button" class="rounded-full bg-white p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <BellIcon class="h-6 w-6" aria-hidden="true" />
                <span class="sr-only">View notifications</span>
              </button>
            </div>
          </div>
        </div>

        <main class="flex-1">
          <div class="relative mx-auto max-w-4xl md:px-8 xl:px-0">
            <div class="pt-10 pb-16">
              <div class="px-4 sm:px-6 md:px-0">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Settings</h1>
              </div>
              <div class="px-4 sm:px-6 md:px-0">
                <div class="py-6">
                  <!-- Tabs -->
                  <div class="lg:hidden">
                    <label for="selected-tab" class="sr-only">Select a tab</label>
                    <select id="selected-tab" name="selected-tab" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-purple-500 focus:outline-none focus:ring-purple-500 sm:text-sm">
                      <option v-for="tab in tabs" :key="tab.name" :selected="tab.current">{{ tab.name }}</option>
                    </select>
                  </div>
                  <div class="hidden lg:block">
                    <div class="border-b border-gray-200">
                      <nav class="-mb-px flex space-x-8">
                        <a v-for="tab in tabs" :key="tab.name" :href="tab.href" :class="[tab.current ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm']">{{ tab.name }}</a>
                      </nav>
                    </div>
                  </div>

                  <!-- Description list with inline editing -->
                  <div class="mt-10 divide-y divide-gray-200">
                    <div class="space-y-1">
                      <h3 class="text-lg font-medium leading-6 text-gray-900">Profile</h3>
                      <p class="max-w-2xl text-sm text-gray-500">This information will be displayed publicly so be careful what you share.</p>
                    </div>
                    <div class="mt-6">
                      <dl class="divide-y divide-gray-200">
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                          <dt class="text-sm font-medium text-gray-500">Name</dt>
                          <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <span class="flex-grow">Chelsea Hagon</span>
                            <span class="ml-4 flex-shrink-0">
                              <button type="button" class="rounded-md bg-white font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Update</button>
                            </span>
                          </dd>
                        </div>
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:pt-5">
                          <dt class="text-sm font-medium text-gray-500">Photo</dt>
                          <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <span class="flex-grow">
                              <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                            </span>
                            <span class="ml-4 flex flex-shrink-0 items-start space-x-4">
                              <button type="button" class="rounded-md bg-white font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Update</button>
                              <span class="text-gray-300" aria-hidden="true">|</span>
                              <button type="button" class="rounded-md bg-white font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Remove</button>
                            </span>
                          </dd>
                        </div>
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:pt-5">
                          <dt class="text-sm font-medium text-gray-500">Email</dt>
                          <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <span class="flex-grow">chelsea.hagon@example.com</span>
                            <span class="ml-4 flex-shrink-0">
                              <button type="button" class="rounded-md bg-white font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Update</button>
                            </span>
                          </dd>
                        </div>
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-b sm:border-gray-200 sm:py-5">
                          <dt class="text-sm font-medium text-gray-500">Job title</dt>
                          <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <span class="flex-grow">Human Resources Manager</span>
                            <span class="ml-4 flex-shrink-0">
                              <button type="button" class="rounded-md bg-white font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Update</button>
                            </span>
                          </dd>
                        </div>
                      </dl>
                    </div>
                  </div>

                  <div class="mt-10 divide-y divide-gray-200">
                    <div class="space-y-1">
                      <h3 class="text-lg font-medium leading-6 text-gray-900">Account</h3>
                      <p class="max-w-2xl text-sm text-gray-500">Manage how information is displayed on your account.</p>
                    </div>
                    <div class="mt-6">
                      <dl class="divide-y divide-gray-200">
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                          <dt class="text-sm font-medium text-gray-500">Language</dt>
                          <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <span class="flex-grow">English</span>
                            <span class="ml-4 flex-shrink-0">
                              <button type="button" class="rounded-md bg-white font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Update</button>
                            </span>
                          </dd>
                        </div>
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:pt-5">
                          <dt class="text-sm font-medium text-gray-500">Date format</dt>
                          <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <span class="flex-grow">DD-MM-YYYY</span>
                            <span class="ml-4 flex flex-shrink-0 items-start space-x-4">
                              <button type="button" class="rounded-md bg-white font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Update</button>
                              <span class="text-gray-300" aria-hidden="true">|</span>
                              <button type="button" class="rounded-md bg-white font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Remove</button>
                            </span>
                          </dd>
                        </div>
                        <SwitchGroup as="div" class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:pt-5">
                          <SwitchLabel as="dt" class="text-sm font-medium text-gray-500" passive>Automatic timezone</SwitchLabel>
                          <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <Switch v-model="automatic_timezone_enabled" :class="[automatic_timezone_enabled ? 'bg-purple-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:ml-auto']">
                              <span aria-hidden="true" :class="[automatic_timezone_enabled ? 'translate-x-5' : 'translate-x-0', 'inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']" />
                            </Switch>
                          </dd>
                        </SwitchGroup>
                        <SwitchGroup as="div" class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-b sm:border-gray-200 sm:py-5">
                          <SwitchLabel as="dt" class="text-sm font-medium text-gray-500" passive>Auto-update applicant data</SwitchLabel>
                          <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <Switch v-model="auto_update_applicant_data_enabled" :class="[auto_update_applicant_data_enabled ? 'bg-purple-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:ml-auto']">
                              <span aria-hidden="true" :class="[auto_update_applicant_data_enabled ? 'translate-x-5' : 'translate-x-0', 'inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']" />
                            </Switch>
                          </dd>
                        </SwitchGroup>
                      </dl>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onErrorCaptured } from 'vue'
import { errorAlert } from '@/converter'

import { Dialog, DialogPanel, Switch, SwitchGroup, SwitchLabel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import {
  ArrowLeftOnRectangleIcon,
  Bars3BottomLeftIcon,
  BellIcon,
  BriefcaseIcon,
  ChatBubbleOvalLeftEllipsisIcon,
  CogIcon,
  DocumentMagnifyingGlassIcon,
  HomeIcon,
  QuestionMarkCircleIcon,
  UsersIcon,
  XMarkIcon,
} from '@heroicons/vue/24/outline'
import { MagnifyingGlassIcon } from '@heroicons/vue/20/solid'

const navigation = [
  { name: 'Home', href: '#', icon: HomeIcon, current: false },
  { name: 'Jobs', href: '#', icon: BriefcaseIcon, current: false },
  { name: 'Applications', href: '#', icon: DocumentMagnifyingGlassIcon, current: false },
  { name: 'Messages', href: '#', icon: ChatBubbleOvalLeftEllipsisIcon, current: false },
  { name: 'Team', href: '#', icon: UsersIcon, current: false },
  { name: 'Settings', href: '#', icon: CogIcon, current: true },
]
const secondaryNavigation = [
  { name: 'Help', href: '#', icon: QuestionMarkCircleIcon },
  { name: 'Logout', href: '#', icon: ArrowLeftOnRectangleIcon },
]
const tabs = [
  { name: 'General', href: '#', current: true },
  { name: 'Password', href: '#', current: false },
  { name: 'Notifications', href: '#', current: false },
  { name: 'Plan', href: '#', current: false },
  { name: 'Billing', href: '#', current: false },
  { name: 'Team Members', href: '#', current: false },
]

const sidebar_open = ref(false)
const automatic_timezone_enabled = ref(true)
const auto_update_applicant_data_enabled = ref(false)

onErrorCaptured((e) => errorAlert('/dashboard/account/(Index)', e))
</script>
