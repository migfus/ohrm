<template>
  <BasicCard
    :icon="TicketIcon"
    title="Customer's Request Template"
    description="Manage request templates and assignments."
  >
    <div class="grid grid-cols-2 gap-2">
      <TaskDropdownMenu
        v-for="task, index in tasks"
        :key="task.name"
        :index="index"
        :name="task.name"
        :color="task.task_priority.color"
        :icon="task.task_priority.hero_icon"
        :priorityName="task.task_priority.name"
        :description="task.description ?? ''"
        @selected="SelectedTaskFromMenu"
        @updated="value => updateTask(value, task.id!)"
        class="col-span-2 lg:col-span-1"
      />
    </div>

    <form @submit.prevent="addTask()">
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
import { TTaskTemplate } from '@/globalTypes'

import { TicketIcon, PlusIcon } from '@heroicons/vue/24/solid'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'
import BasicCard from '@/components/cards/BasicCard.vue'
import TaskDropdownMenu from '../TaskDropdownMenu.vue'
import AppInput from '@/components/form/AppInput.vue'
import AppButton from '@/components/form/AppButton.vue'
import { router } from '@inertiajs/vue3'

const $props = defineProps<{
  id: string
  tasks: TTaskTemplate []
}>()

const initTemplateTask =  {
  id: '',
  group_id: '',
  task_priority: {
    id: '',
    name: '',
    color: '',
    hero_icon:{
      name: '',
      content: ''
    }
  },
  name: '',
  is_show: true,
}

const removeOpen = ref<boolean>(false)
const selectedIndex = ref<number>()
const inputTask = ref<TTaskTemplate>(initTemplateTask)



function SelectedTaskFromMenu(value: {type: string, index: number}) {
  switch(value.type) {
    case 'remove':
      removeOpen.value = true
      selectedIndex.value = value.index
      break;
    default:
      inputTask.value = $props.tasks[value.index]
  }
}
function ConfirmRemove() {
  if(selectedIndex!.value !== undefined) {
    removeTask()
  }
}


function addTask() {
  if(inputTask.value !== null) {
    router.put(`/dashboard/manage-groups/${$props.id}`, {
      name: inputTask?.value.name ?? '',
      type: 'addTask',
    }, {
      onSuccess: () => {
        inputTask.value = initTemplateTask
      },
      preserveScroll: true,
      preserveState: true,
    })
  }
}

function removeTask() {
  if(selectedIndex!.value !== undefined) {
    router.put(`/dashboard/manage-groups/${$props.id}`, {
      taskId: $props.tasks[selectedIndex.value].id,
      type: 'removeTask',
    },{
      preserveScroll: true,
      preserveState: true
    })
  }
}

function updateTask(name: string, id: string) {
  if(id !== '') {
    router.put(`/dashboard/manage-groups/${$props.id}`, {
      taskId: id,
      name: name,
      type: 'updateTask',
    },{
      preserveState: true,
      preserveScroll: true
    })
  }
}
</script>
