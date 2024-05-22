import { TCTopNavigation } from "./globalTypes"
import {
  HomeIcon,
  RssIcon,
  QuestionMarkCircleIcon,
  TableCellsIcon,
  Cog6ToothIcon,
  SquaresPlusIcon,
  UsersIcon,
  ShieldCheckIcon,
  FolderPlusIcon,
  FolderIcon
} from "@heroicons/vue/24/outline"

export const CTopNavigation: TCTopNavigation[] = [
  {
    name: 'Home',
    icon: HomeIcon,
    href: '/',
    component: 'home/(Page)',
  },
  {
    name: 'Status',
    icon: RssIcon,
    href: '/status',
    component: 'status/(Page)',
  },
  {
    name: 'About Us',
    icon: QuestionMarkCircleIcon,
    href: '/about',
    component: 'about/(Page)',
  },
]

export const CSidebarNavigation: TCTopNavigation[] = [
  {
    name: 'Dashboard',
    icon: SquaresPlusIcon,
    href: '/dashboard',
    component: 'dashboard/(Page)'
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
    component: 'dashboard/account/(Page)'
  }
]

export const CAdminNavigation: TCTopNavigation[] = [
  {
    name: 'Manage Groups',
    icon: SquaresPlusIcon,
    href: '/dashboard/manage-groups',
    component: 'dashboard/manage-groups/(Index)'
  },
  {
    name: 'Manage Users',
    icon: UsersIcon,
    href: '/dashboard/manage-users',
    component: 'dashboard/manage-users/(Index)'
  },
  {
    name: 'Manage Roles & Permission',
    icon: ShieldCheckIcon,
    href: '/dashboard/manage-roles-permissions',
    component: 'dashboard/manage-roles-permissions/(Page)'
  },
  {
    name: 'System Settings',
    icon: Cog6ToothIcon,
    href: '/dashboard/system-settings',
    component: 'dashboard/SystemSettings/(Page)'
  }
]
