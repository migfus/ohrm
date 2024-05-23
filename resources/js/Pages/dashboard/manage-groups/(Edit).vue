<template>
  <div>
    <GroupHeader v-model:avatar="form.avatar" v-model:cover="form.cover" :form :head="data.head[0]"/>
  </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'

import GroupHeader from './GroupHeader.vue'
import { TTeam, TUser } from '@/globalTypes';

const $props = defineProps<{
  data: TTeam
}>()

const form = router.form({
  name: $props.data.display_name,
  description: $props.data.description,
  avatar: $props.data.avatar,
  cover: $props.data.cover,
  head: $props.data.head
})

function submit() {

}
</script>
