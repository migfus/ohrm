import { TCTopNavigation } from "./globalTypes"
import {
  HomeIcon,
  RssIcon,
  QuestionMarkCircleIcon,
  Cog6ToothIcon,
  SquaresPlusIcon,
  ShieldCheckIcon,
  FolderPlusIcon,
  FolderIcon,
  AtSymbolIcon
} from "@heroicons/vue/24/outline"

export const CTopNavigation: TCTopNavigation[] = [
  {
    name: 'Home',
    icon: HomeIcon,
    href: '/',
    component: 'home/(Index)',
  },
  {
    name: 'Status',
    icon: RssIcon,
    href: '/status',
    component: 'status/(Index)',
  },
  {
    name: 'About Us',
    icon: QuestionMarkCircleIcon,
    href: '/about',
    component: 'about/(Index)',
  },
]

export const CSidebarNavigation: TCTopNavigation[] = [
  {
    name: 'Dashboard',
    icon: SquaresPlusIcon,
    href: '/dashboard',
    component: 'dashboard/(Index)'
  },
  {
    name: 'My Groups',
    icon: FolderPlusIcon,
    href: '/dashboard/my-groups',
    component: 'dashboard/MyGroups'
  },
  {
    name: 'Joined Groups',
    icon: FolderIcon,
    href: '/dashboard/joined-groups',
    component: 'dashboard/JoinedGroups'
  },
  {
    name: 'Account Settings',
    icon: Cog6ToothIcon,
    href: '/dashboard/account',
    component: 'dashboard/account/(Index)'
  }
]

export const CAdminNavigation: TCTopNavigation[] = [
  {
    name: 'Manage Groups',
    icon: SquaresPlusIcon,
    href: '/dashboard/manage-groups',
    component: 'dashboard/manage-groups/index/(Index)'
  },
  {
    name: 'Manage Users',
    icon: AtSymbolIcon,
    href: '/dashboard/manage-users',
    component: 'dashboard/manage-users/(Index)'
  },
  {
    name: 'System\'s Roles & Permission',
    icon: ShieldCheckIcon,
    href: '/dashboard/system-roles-permissions',
    component: 'dashboard/system-roles-permissions/(Index)'
  },
  {
    name: 'System Settings',
    icon: Cog6ToothIcon,
    href: '/dashboard/system-settings',
    component: 'dashboard/system-settings/(Index)'
  }
]
