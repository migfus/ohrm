<template>
  <BasicCard
    :icon="TicketIcon"
    title="Customer's Request Template"
    description="Manage request templates and assignments."
  >
    <DataTransition class="grid grid-cols-2 gap-2">
      <TaskDropdownMenu
        v-for="task, index in tasks"
        :id="task.id"
        :key="task.name"
        :index="index"
        :name="task.name"
        :color="task.task_priority.color"
        :icon="task.task_priority.hero_icon"
        :priorityName="task.task_priority.name"
        :description="task.description ?? ''"
        :userAssigns="task.task_user_access"
        :userCount="task.task_user_access_count - 5"
        :task="task"
        @selected="SelectedTaskFromMenu"
        class="col-span-2 lg:col-span-1"
      />
    </DataTransition>

    <div class="flex justify-end mt-4">
      <AppButton @click="showAddTask = true" :icon="PlusIcon" color="brand" size="sm" type="submit">Add Request</AppButton>
    </div>

    <RemovalPrompt v-model="removeOpen" @confirm="ConfirmRemove" confirmMessage="Yes, Remove The Member" title="Removing a Member">
      Are you sure do you want to remove this member?
    </RemovalPrompt>

    <FormModal v-model="showAddTask" title="Add New Template Request" description="Add New Template Request" :icon="PlusIcon" size="max-w-md">
      <form @submit.prevent="addTask">
        <AppInput v-model="form.name" name="Name" :error="undefined"/>
        <AppTextArea v-model="form.description" name="Description" :error="undefined"/>
        <ComboBox
          v-model="form.priority"
          name="Default Priority"
          :data="taskPriority.map(row => {
            return {
              name: row.name,
              display_name: row.name,
              id: row.id,
            }
          })"
          class="mt-4"
        />
        <AppToggle v-model="form.isShow" name="Show to public"/>

        <div class="flex justify-end mt-4 gap-2">
          <AppButton @click="showAddTask = false; form.reset()" :icon="XMarkIcon" color="danger" type="button">Cancel</AppButton>
          <AppButton @click="showAddTask = false" :icon="PlusIcon" color="brand" type="submit">Add</AppButton>
        </div>
      </form>
    </FormModal>
  </BasicCard>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { TTaskPriority, TTaskTemplate } from '@/globalTypes'

import { TicketIcon, PlusIcon, XMarkIcon } from '@heroicons/vue/24/solid'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'
import BasicCard from '@/components/cards/BasicCard.vue'
import TaskDropdownMenu from '../TaskDropdownMenu.vue'
import FormModal from '@/components/modals/FormModal.vue'
import AppButton from '@/components/form/AppButton.vue'
import { router } from '@inertiajs/vue3'
import AppInput from '@/components/form/AppInput.vue'
import AppTextArea from '@/components/form/AppTextArea.vue'
import AppToggle from '@/components/form/AppToggle.vue'
import ComboBox from '@/components/form/ComboBox.vue'
import DataTransition from '@/components/transitions/DataTransition.vue'

const $props = defineProps<{
  id: string
  tasks: TTaskTemplate []
  taskPriority: TTaskPriority []
}>()

const removeOpen = ref<boolean>(false)
const selectedIndex = ref<number>()
const showAddTask = ref<boolean>(false)

const form = router.form({
  name: '',
  description: '',
  priority: {
    name: $props.taskPriority[2].name,
    display_name: $props.taskPriority[2].name,
    id: $props.taskPriority[2].id,
  },
  isShow: true,
})

function SelectedTaskFromMenu(value: {type: string, index: number}) {
  switch(value.type) {
    case 'remove':
      removeOpen.value = true
      selectedIndex.value = value.index
      break;
    default:
      // inputTask.value = $props.tasks[value.index]
  }
}
function ConfirmRemove() {
  if(selectedIndex!.value !== undefined) {
    removeTask()
  }
}

// ✅
function addTask() {
  router.put(`/dashboard/manage-groups/${$props.id}`, {
    name: form.name,
    description: form.description,
    priority_id: form.priority.id,
    is_show: form.isShow,
    type: 'addTask',
  }, {
    onSuccess: () => {
      form.reset()
    },
    preserveScroll: true,
    preserveState: true,
  })
}

// ✅
function removeTask() {
  if(selectedIndex!.value !== undefined) {
    router.put(`/dashboard/manage-groups/${$props.id}`, {
      taskId: $props.tasks[selectedIndex.value].id,
      type: 'removeTask',
    },{
      preserveScroll: true,
      preserveState: true,
    })
  }
}
</script>
