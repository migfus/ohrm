<template>
  <div>
    <div class="relative border-b border-gray-200 bg-brand-50 py-4 rounded-xl shadow pb-5 sm:pb-0">
      <div class="md:flex md:items-center md:justify-between px-4">
        <h3 class="text-lg font-medium leading-6 text-brand-700">Manage Users</h3>
        <div class="mt-3 flex">
          <AppInput :error="undefined" name="Search" placeholder="Search" noLabel class="flex-grow"/>
          <AppButton color="brand" class="pt-3 ml-2">Add User</AppButton>
        </div>
      </div>
      <div class="mt-4">
        <div class="sm:hidden px-4">
          <label for="current-tab" class="sr-only">Select a tab</label>
          <select id="current-tab" name="current-tab" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-brand-500 focus:outline-none focus:ring-brand-500 sm:text-sm">
            <option v-for="tab in tabs" :key="tab.name" :selected="tab.current">{{ tab.name }}</option>
          </select>
        </div>
        <div class="hidden sm:block px-4">
          <nav class="-mb-px flex space-x-8">
            <a v-for="tab in tabs" :key="tab.name" :href="tab.href" :class="[tab.current ? 'border-brand-500 text-brand-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm']" :aria-current="tab.current ? 'page' : undefined">{{ tab.name }}</a>
          </nav>
        </div>

        <div class="overflow-hidden bg-white shadow sm:rounded-xl mt-2">
          <ul role="list" class="divide-y divide-gray-200">
            <UserCard v-for="row in applications" :data="row" :key="row.applicant.name"/>
          </ul>
        </div>

        <PaginationCard />
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import UserCard from '@/components/data/UserCard.vue'
import PaginationCard from '@/components/data/PaginationCard.vue'
import AppInput from '@/components/form/AppInput.vue'
import AppButton from '@/components/form/AppButton.vue'
import { TProps } from '@/globalTypes'

interface TData {
  applicant: {
    name: string
    email: string
    imageUrl: string
  }
  date: string
  dateFull: string
  stage: string
  href: string
  position: string
}

interface TData extends TProps {
  roles: {
    name: string
    display_name: string
  } []
}

const $props = defineProps<TData>()

const applications: TData [] = [
  {
    applicant: {
      name: 'Ricardo Cooper',
      email: 'ricardo.cooper@example.com',
      imageUrl:
        'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    date: '2020-01-07',
    dateFull: 'January 7, 2020',
    stage: 'Human Resource Information System (HRIS)',
    href: '#',
    position: 'Clerk',
  },
  {
    applicant: {
      name: 'Kristen Ramos',
      email: 'kristen.ramos@example.com',
      imageUrl:
        'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    date: '2020-01-07',
    dateFull: 'January 7, 2020',
    stage: 'Recruitment Selection Program (RSP)',
    href: '#',
    position: 'Administrattive Aide III',
  },
  {
    applicant: {
      name: 'Ted Fox',
      email: 'ted.fox@example.com',
      imageUrl:
        'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    date: '2020-01-07',
    dateFull: 'January 7, 2020',
    stage: 'Benefits and Awards (BA)',
    href: '#',
    position: 'Administrattive Officer III',
  },
]

const tabs = [
  { name: 'All', href: '#', current: true },
  { name: 'Staff', href: '#', current: false },
  { name: 'Unit Head', href: '#', current: false },
  { name: 'Office Head', href: '#', current: false },
  { name: 'Admin', href: '#', current: false },
  { name: 'Disabled', href: '#', current: false },
]
</script>
