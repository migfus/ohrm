<template>
  <BasicCard
    :icon="TicketIcon"
    title="Customer's Request Template"
    description="Manage request templates and assignments."
  >
    <DataTransition class="grid grid-cols-2 gap-2">
      <TaskDropdownMenu
        v-for="template, index in taskTemplates"
        :key="template.name"
        :index="index"
        :taskTemplate="template"
        @selected="SelectedTaskFromMenu"
        class="col-span-2 lg:col-span-1"
      />
    </DataTransition>

    <div class="flex justify-end mt-4">
      <AppButton @click="show_add_task = true" :icon="PlusIcon" color="brand" size="sm" type="submit">Add Request</AppButton>
    </div>

    <RemovalPrompt v-model="remove_open" @confirm="ConfirmRemove" confirmMessage="Yes, Remove The Member" title="Removing a Member">
      Are you sure do you want to remove this member?
    </RemovalPrompt>

    <FormModal v-model="show_add_task" title="Add New Template Request" description="Add New Template Request" :icon="PlusIcon" size="max-w-md">
      <form @submit.prevent="addTask">
        <AppInput v-model="form.name" name="Name" :error="undefined"/>
        <AppTextArea v-model="form.description" name="Description" :error="undefined"/>
        <ComboBox
          v-model="form.priority"
          name="Default Priority"
          :data="taskPriorities.map((row: any) => {
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
          <AppButton @click="show_add_task = false; form.reset()" :icon="XMarkIcon" color="danger" type="button">Cancel</AppButton>
          <AppButton @click="show_add_task = false" :icon="PlusIcon" color="brand" type="submit">Add</AppButton>
        </div>
      </form>
    </FormModal>
  </BasicCard>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Tab, TaskPriority, TaskTemplate } from '@/globalTypes'
import { defaultRouterState } from '@/converter'
import { router } from '@inertiajs/vue3'

import { TicketIcon, PlusIcon, XMarkIcon } from '@heroicons/vue/24/solid'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'
import BasicCard from '@/components/cards/BasicCard.vue'
import TaskDropdownMenu from '../TaskDropdownMenu.vue'
import FormModal from '@/components/modals/FormModal.vue'
import AppButton from '@/components/form/AppButton.vue'
import AppInput from '@/components/form/AppInput.vue'
import AppTextArea from '@/components/form/AppTextArea.vue'
import AppToggle from '@/components/form/AppToggle.vue'
import ComboBox from '@/components/form/ComboBox.vue'
import DataTransition from '@/components/transitions/DataTransition.vue'

const $props = defineProps<{
  groupId: string
  taskTemplates: TaskTemplate []
  taskPriorities: TaskPriority []
}>()

const remove_open = ref<boolean>(false)
const selected_index = ref<number>()
const show_add_task = ref<boolean>(false)

const form = router.form({
  name: '',
  description: '',
  priority: {
    name: $props.taskPriorities[2].name,
    display_name: $props.taskPriorities[2].name,
    id: $props.taskPriorities[2].id,
  },
  isShow: true,
})

function SelectedTaskFromMenu(value: {type: string, index: number}) {
  switch(value.type) {
    case 'remove':
      remove_open.value = true
      selected_index.value = value.index
      break;
    default:
      // inputTask.value = $props.tasks[value.index]
  }
}
function ConfirmRemove() {
  if(selected_index!.value !== undefined) {
    removeTask()
  }
}

// ✅
function addTask() {
  router.put(route('dashboard.manage-groups.update', { manage_group: $props.groupId }), {
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
  if(selected_index!.value !== undefined) {
    router.put(route('dashboard.manage-groups.update', { manage_group: $props.groupId }), {
        taskId: $props.taskTemplates[selected_index.value].id,
        type: 'removeTask',
      },
      defaultRouterState([''])
    )
  }
}
</script>
