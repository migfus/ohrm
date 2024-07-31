import { TopNavigation } from "./globalTypes"
import {
  HomeIcon,
  RssIcon,
  QuestionMarkCircleIcon,
  Cog6ToothIcon,
  SquaresPlusIcon,
  ShieldCheckIcon,
  FolderPlusIcon,
  AtSymbolIcon
} from "@heroicons/vue/24/solid"

export const CTopNavigation: TopNavigation[] = [
  {
    name: 'Home',
    icon: HomeIcon,
    href: '/',
    components: ['home/(Index)'],
  },
  {
    name: 'Status',
    icon: RssIcon,
    href: '/status',
    components: ['status/(Index)'],
  },
  {
    name: 'About Us',
    icon: QuestionMarkCircleIcon,
    href: '/about',
    components: ['about/(Index)'],
  },
]

export const CSidebarNavigation: TopNavigation[] = [
  {
    name: 'Dashboard',
    icon: SquaresPlusIcon,
    href: '/dashboard',
    components: ['dashboard/index/(Index)']
  },
  {
    name: 'My Groups',
    icon: FolderPlusIcon,
    href: '/dashboard/my-groups',
    components: ['dashboard/my-groups/(Index)'],
  },
  {
    name: 'Account Settings',
    icon: Cog6ToothIcon,
    href: '/dashboard/account',
    components: ['dashboard/account/(Index)']
  }
]

export const CAdminNavigation: TopNavigation[] = [
  {
    name: 'Manage Groups',
    icon: SquaresPlusIcon,
    href: '/dashboard/manage-groups',
    components: [
      'dashboard/manage-groups/index/(Index)',
      'dashboard/manage-groups/edit/(Edit)',
    ]
  },
  {
    name: 'Manage Users',
    icon: AtSymbolIcon,
    href: '/dashboard/manage-users',
    components: [
      'dashboard/manage-users/index/(Index)',
      'dashboard/manage-users/edit/(Edit)',
    ]
  },
  {
    name: 'System\'s Roles & Permission',
    icon: ShieldCheckIcon,
    href: '/dashboard/system-roles-permissions',
    components: ['dashboard/system-roles-permissions/(Index)']
  },
  {
    name: 'System Settings',
    icon: Cog6ToothIcon,
    href: '/dashboard/system-settings',
    components: ['dashboard/system-settings/(Index)']
  }
]
