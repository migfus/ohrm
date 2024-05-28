<template>
  <BasicCard
    :icon="TicketIcon"
    title="Group's Tasks"
    description="Tasks list for this group."
  >
    <TaskDropdownMenu
      v-for="task, index in $model"
      :key="task.name"
      :index="index"
      :name="task.name"
      @selected="SelectedTaskFromMenu"
      @updated="(value) => task.name = value"
    />

    <form @submit.prevent="AddTask()">
      <AppInput v-model="inputTask.name" :error="undefined" name="Add Task" size="sm" />
      <div class="flex justify-end mt-2">
        <AppButton :icon="PlusIcon" color="brand" size="sm" type="submit">Add Task</AppButton>
      </div>
    </form>



    <RemovalPrompt v-model="removeOpen" @confirm="ConfirmRemove" confirmMessage="Yes, Remove The Member" title="Removing a Member">
      Are you sure do you want to remove this member?
    </RemovalPrompt>
  </BasicCard>
</template>

<script setup lang="ts">
import { ref } from 'vue'

import { TicketIcon, PlusIcon } from '@heroicons/vue/24/solid'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'
import BasicCard from '@/components/cards/BasicCard.vue'
import TaskDropdownMenu from '../TaskDropdownMenu.vue'
import AppInput from '@/components/form/AppInput.vue'
import AppButton from '@/components/form/AppButton.vue'

const $model = defineModel<{
  name: string
}[]>()

const removeOpen = ref<boolean>(false)
const selectedIndex = ref<number>()
const inputTask = ref<{
  name: string
}>({ name: ''})

function AddTask() {
  if(inputTask.value.name != '') {
    $model.value!.push({
      name: inputTask.value.name,
    })
    inputTask.value.name = ''
  }
}
function SelectedTaskFromMenu(value: {type: string, index: number}) {
  switch(value.type) {
    case 'remove':
      removeOpen.value = true
      selectedIndex.value = value.index
      break;
    default:
      inputTask.value = $model.value![value.index]
  }
}
function ConfirmRemove() {
  if(selectedIndex!.value !== undefined) {
    $model.value?.splice(selectedIndex.value, 1)
  }
}
</script>
