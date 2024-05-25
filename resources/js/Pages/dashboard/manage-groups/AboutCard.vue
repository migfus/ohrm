<template>
  <div class="bg-brand-50 p-4 shadow rounded-xl group">
    <div class="px-4 sm:px-0">
      <div class="flex justify-between">
        <h3 class="text-base font-semibold leading-7 text-gray-900">
          <AdjustmentsHorizontalIcon class="text-sm text-brand-700 h-4 w-4 inline mr-1 mb-[3px] align-middle"/>
          Update Basic Information
        </h3>
      </div>

      <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Modify basic information of the group.</p>
    </div>

    <div class="mt-6">
      <dl class="">
        <div class="mb-4">
          <dd class="text-sm leading-6 text-gray-700 ">Name</dd>
          <BasicTransition>
            <form @submit.prevent="submit" v-if="active == 'name'">
              <AppInput v-model="form.name" size="sm" name="Name" :error="undefined" noLabel/>
              <div class="flex justify-end gap-2 mt-2">
                <AppButton type="button" @click="cancel()" size="sm">Cancel</AppButton>
                <AppButton type="submit" size="sm" color="brand">Update</AppButton>
              </div>
            </form>
            <dt v-else @click="active = 'name'" class="cursor-pointer text-sm font-medium leading-6 text-gray-900 bg-white rounded-xl shadow py-2 px-4">
              <div class="flex justify-between">
                <div class="">
                  <span class="text-brand-500">g/</span>
                  <span>
                    {{ form.name }}
                  </span>
                </div>
                <div>
                  <PencilIcon class="text-sm text-brand-700 h-4 w-4 inline mb-[3px] align-middle group-hover:opacity-100 transition-all sm:opacity-0"/>
                </div>
              </div>
            </dt>
          </BasicTransition>
        </div>

        <div class="mb-4">
          <dd class="text-sm leading-6 text-gray-700">Description</dd>
          <BasicTransition>
            <form @submit.prevent="submit" v-if="active == 'description'" >
              <AppInput v-model="form.description" size="sm" name="Description" :error="undefined" noLabel/>
              <div class="flex justify-end gap-2 mt-2">
                <AppButton type="button" @click="cancel()" size="sm">Cancel</AppButton>
                <AppButton type="submit" size="sm" color="brand">Update</AppButton>
              </div>
            </form>
            <dt v-else @click="active = 'description'" class="cursor-pointer bg-white px-4 py-2 shadow rounded-xl text-sm font-medium leading-6 text-gray-900">
              <div class="flex justify-between">
                <div class="">
                  {{ form.description }}
                </div>
                <div>
                  <PencilIcon class="text-sm text-brand-700 h-4 w-4 inline mb-[3px] align-middle group-hover:opacity-100 transition-all sm:opacity-0"/>
                </div>
              </div>
            </dt>
          </BasicTransition>
        </div>

      </dl>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { TTeam } from '@/globalTypes'
import { router } from '@inertiajs/vue3'

import AppInput from '@/components/form/AppInput.vue'
import AppButton from '@/components/form/AppButton.vue'
import BasicTransition from '@/components/transitions/BasicTransition.vue'
import { AdjustmentsHorizontalIcon, PencilIcon } from '@heroicons/vue/24/solid'

const active = ref<string | null>(null)

const $props = defineProps<{
  group: TTeam
}>()

const form = router.form({
  name: $props.group.display_name,
  description: $props.group.description,
})

function cancel() {
  active.value = null
  Object.assign(form, {
    name: $props.group.display_name,
    description: $props.group.description,
  })
}

function submit() {
  active.value = null
  router.put(`/dashboard/manage-groups/${$props.group.id}`, {
    type: 'basic',
    name: form.name,
    description: form.description,
  })
}
</script>
