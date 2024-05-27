<template>
  <div ref="el">
    <HeaderContent
      v-model="throttledSearch"
      :allowSearch="true"
      title="Manage Users"
      desc="Create, modify, or generate report users informations"
      @add="router.visit('/dashboard/manage-users/create')"
    />

    <TabSection v-model="selected" :data="roles" @selectedData="changeTab"/>


    <div class="overflow-hidden bg-white shadow sm:rounded-xl mt-2">
      <DataTransition v-if="$props.data.data.length > 0" role="list" class="divide-y divide-gray-200">
        <UserCard v-for="row in $props.data.data" :data="row" :key="row.id"/>
      </DataTransition>
      <DataTransition v-else>
        <div class="bg-brand-50 p-4 text-brand-600 flex justify-center">
          <p class="mx-auto text-[60px]">
            <span class="animate-pulse">Not Found </span>
            <span class="text-[60px] m-4 animate-pulse delay-200">😅</span>
          </p>
        </div>
      </DataTransition>
    </div>

    <PaginationCard :data @changePage="changePage" />

  </div>
</template>

<script setup lang="ts">
import { watch, reactive, ref } from 'vue'
import { useThrottle } from '@vueuse/core'

import UserCard from '@/components/data/UserCard.vue'
import PaginationCard from '@/components/data/PaginationCard.vue'
import { TFilters, TPagination, TUser, TTab } from '@/globalTypes'
import { router } from '@inertiajs/vue3'
import DataTransition from '@/components/transitions/DataTransition.vue'
import HeaderContent from '@/components/header/HeaderContent.vue'
import TabSection from '@/components/header/TabSection.vue'

const $props = defineProps<{
  filters: TFilters
  roles: TTab []
  data: TPagination<TUser>
}>()

const throttledSearch = ref($props.filters.search ?? '')
const selected = ref(0)
const form = reactive({
  type: $props.filters.type ?? null,
  search: useThrottle(throttledSearch, 1000),
  page: 1
})

watch(form, () => {
  search()
})

function changePage(page: number) {
  form.page = page
}
function changeTab(data: { name: string }) {
  form.type = data.name
}
function search() {
  router.get('/dashboard/manage-users', form, { preserveState: true })
}
</script>
