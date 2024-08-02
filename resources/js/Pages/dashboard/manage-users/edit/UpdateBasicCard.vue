<template>
  <BasicCard :icon="AdjustmentsHorizontalIcon" title="Update Basic Information" description="Update basic information of the user">
    <AppToggleInput
      v-model="form.name"
      name="Name"
      :defaultValue="form.name"
      @submit="submit()"
    />

    <AppToggleInput
      v-model="form.email"
      name="Email"
      :defaultValue="form.email"
      @submit="submit()"
    />

    <AppToggleInput
      v-model="form.password"
      name="Password"
      :defaultValue="form.password"
      @submit="submit()"
      :enablePasswordGenerator="true"
    />
  </BasicCard>

</template>

<script setup lang="ts">
import { reactive, ref, onErrorCaptured } from 'vue'
import { User } from '@/globalTypes'
import { router } from '@inertiajs/vue3'
import { errorAlert } from '@/converter'

import { AdjustmentsHorizontalIcon } from '@heroicons/vue/24/solid'
import BasicCard from '@/components/cards/BasicCard.vue'
import AppToggleInput from '@/components/form/AppToggleInput.vue'

const active = ref<string | null>(null)

const $props = defineProps<{
  user: User
}>()

const form = reactive({
  name: $props.user.name,
  email: $props.user.email,
  password: '●●●●●●●●',
})

function submit() {
  active.value = null
  router.put(route('dashboard.manage-users.update', {manage_user: $props.user.id}), {
    type: 'basic',
    _name: $props.user.name,
    _email: $props.user.email,
    ...form
  })
}

onErrorCaptured((e) => errorAlert('/dashboard/manage-users/edit/UpdateBasicCard', e))
</script>
