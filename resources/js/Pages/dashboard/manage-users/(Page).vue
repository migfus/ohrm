<template>
  <div>
    <div class="relative border-b border-gray-200 bg-brand-50 py-4 rounded-xl shadow pb-5 sm:pb-0">
      <div class="md:flex md:items-center md:justify-between px-4">
        <h3 class="text-lg font-medium leading-6 text-brand-700">Manage Users</h3>
        <div class="mt-3 flex">
          <AppButton color="brand" class="pt-3 mr-1">Add User</AppButton>
          <AppInput v-model="input" :error="undefined" name="Search" placeholder="Search" noLabel class="flex-grow"/>
        </div>
      </div>
      <div class="mt-4">
        <div class="sm:hidden px-4">
          <label for="current-tab" class="sr-only">Select a tab</label>
          <select v-model="form.type" id="current-tab" name="current-tab" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-brand-500 focus:outline-none focus:ring-brand-500 sm:text-sm">
            <option v-for="(tab, index) in $props.roles" :key="tab.name" :selected="form.type == tab.name" :value="tab.name">{{ tab.display_name }}</option>
          </select>
        </div>
        <div class="hidden sm:block px-4">
          <nav class="-mb-px flex space-x-8">
            <div
              v-for="(tab, index) in $props.roles"
              :key="tab.name"
              @click="form.type = tab.name"
              :class="[form.type == tab.name ? 'border-brand-500 text-brand-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm cursor-pointer']"
              :aria-current="form.type == tab.name ? 'page' : undefined">
              {{ tab.display_name }}
            </div>
          </nav>
        </div>

        <div class="overflow-hidden bg-white shadow sm:rounded-xl mt-2">
          <DataTransition role="list" class="divide-y divide-gray-200">
            <UserCard v-for="row in $props.data.data" :data="row" :key="row.id"/>
          </DataTransition>
        </div>

        <PaginationCard />
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { watch, reactive, ref } from 'vue'
import { useThrottle } from '@vueuse/core'

import UserCard from '@/components/data/UserCard.vue'
import PaginationCard from '@/components/data/PaginationCard.vue'
import AppInput from '@/components/form/AppInput.vue'
import AppButton from '@/components/form/AppButton.vue'
import { TPagination, TProps, TUser } from '@/globalTypes'
import { router } from '@inertiajs/vue3'
import DataTransition from '@/components/transitions/DataTransition.vue'

interface TDataT {
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
  data: TPagination<TUser>
}

const $props = defineProps<TData>()

const input = ref('')
const form = reactive({
  type: 'all',
  search: useThrottle(input, 1000),
})

watch(form, () => {
  search()
})


function search() {
  router.get('/dashboard/manage-users', form, { preserveState: true })
}
</script>
