<template>
  <div class="my-4 flex flex-col gap-4">
    <BasicCard v-for="group in groups" :key="group.id" :icon="BriefcaseIcon" :title="group.display_name"></BasicCard>
  </div>

</template>

<script setup lang="ts">
import { TTeam } from '@/globalTypes'
import {
  BriefcaseIcon,
  DocumentDuplicateIcon,
  ArrowPathIcon,
  ChartBarIcon,
  CalendarDaysIcon,
  PencilIcon,
  CreditCardIcon,
  BanknotesIcon,
  BuildingLibraryIcon,
  CheckBadgeIcon,
  DocumentCheckIcon,
  FingerPrintIcon,
  FolderIcon,
  HandThumbUpIcon,
  TrophyIcon
} from '@heroicons/vue/24/solid'
import BasicCard from '@/components/cards/BasicCard.vue'

defineProps<{
  groups: TTeam []
}>()


const menu = [
  {
    category: 'RSP - Recruitment, Selection & Placement',
    color: 'bg-brand-800/5',
    children: [
      {
        name: 'Application Concern',
        color: 'bg-rose-700 text-rose-50',
        image: 'https://images.unsplash.com/photo-1635350736475-c8cef4b21906?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: BriefcaseIcon,
      },
      {
        name: 'Job Order Contract',
        color: 'bg-cyan-700 text-cyan-50',
        image: 'https://images.unsplash.com/photo-1564846824194-346b7871b855?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: DocumentDuplicateIcon,
      },
      {
        name: 'Renewal/PDS',
        color: 'bg-yellow-600 text-yellow-50',
        image: 'https://images.unsplash.com/photo-1562654501-a0ccc0fc3fb1?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: ArrowPathIcon,
      },
    ],
  },
  {
    category: 'LD - Learning & Development',
    color: 'bg-cyan-800/5',
    children: [
      {
        name: 'Seminar Concern',
        color: 'bg-yellow-600 text-yellow-50',
        image: 'https://plus.unsplash.com/premium_photo-1661952480813-2bb91e2104df?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: ChartBarIcon,
      },
    ]
  },
  {
    category: 'CBERU - Compensation, Benefits & Employee Relation Unit',
    color: 'bg-amber-800/5',
    children: [
      {
        name: 'Leaves Concern',
        color: 'bg-yellow-600 text-yellow-50',
        image: 'https://plus.unsplash.com/premium_photo-1661589592495-a48a36ad094c?q=80&w=871&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: HandThumbUpIcon,
      },
      {
        name: 'Loyalty Rewards',
        color: 'bg-lime-600 text-lime-50',
        image: 'https://images.unsplash.com/photo-1514820720301-4c4790309f46?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: TrophyIcon,
      },
      {
        name: 'Service Records',
        color: 'bg-yellow-600 text-yellow-50',
        image: 'https://images.unsplash.com/photo-1634028019864-c1f249ad1b03?q=80&w=1824&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: DocumentCheckIcon,
      },
      {
        name: 'Certificate of Employement',
        color: 'bg-cyan-600 text-cyan-50',
        image: 'https://images.unsplash.com/photo-1529400971008-f566de0e6dfc?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: CheckBadgeIcon,
      },
      {
        name: 'SALN',
        color: 'bg-gray-600 text-gray-50',
        image: 'https://plus.unsplash.com/premium_photo-1679942202526-2d9846b8dd52?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: BuildingLibraryIcon,
      },
      {
        name: 'Landbank Concern',
        color: 'bg-yellow-600 text-yellow-50',
        image: 'https://images.gmanews.tv/webpics/2021/12/landbank_logo_2021_12_12_18_42_13.jpg',
        icon: BanknotesIcon,
      },
    ]
  },
  {
    category: 'HRIS - Human Resource Information System Unit Process',
    color: 'bg-red-800/5',
    children: [
      {
        name: 'Biometrics Concern',
        color: 'bg-rose-600 text-rose-50',
        image: 'https://plus.unsplash.com/premium_photo-1677093905889-c60a2db5d5c8?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8YmlvbWV0cmljfGVufDB8fDB8fHww',
        icon: FingerPrintIcon,
      },
      {
        name: 'Request 201 Files',
        color: 'bg-indigo-600 text-indigo-50',
        image: 'https://images.unsplash.com/photo-1596633313465-1256feb1c6d9?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: FolderIcon,
      },
      {
        name: 'Request Employee ID',
        color: 'bg-green-600 text-green-50',
        image: 'https://images.unsplash.com/photo-1577345848762-8b7cab61de4d?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: CreditCardIcon,
      },
    ]
  },
  {
    category: 'PM - Performance Management',
    color: 'bg-blue-800/5',
    children: [
      {
        name: 'PEMIRES Concern',
        color: 'bg-rose-600 text-rose-50',
        image: 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=1332&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: CalendarDaysIcon,
      },
      {
        name: 'IPCR Concern',
        color: 'bg-indigo-600 text-indigo-50',
        image: 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        icon: PencilIcon,
      },
    ]
  },
]
</script>
