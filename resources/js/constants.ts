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
  },
  {
    name: 'Status',
    icon: RssIcon,
    href: '/status',
  },
  {
    name: 'Contact Us',
    icon: QuestionMarkCircleIcon,
    href: '/contact',
  },
]

export const CSidebarNavigation: TCTopNavigation[] = [
  {
    name: 'Dashboard',
    icon: SquaresPlusIcon,
    href: '/dashboard'
  },
  {
    name: 'My Groups',
    icon: FolderPlusIcon,
    href: '/dashboard/my-groups'
  },
  {
    name: 'Joined Groups',
    icon: FolderIcon,
    href: '/dashboard/joined-groups'
  },
  {
    name: 'Account Settings',
    icon: Cog6ToothIcon,
    href: '/dashboard/account'
  }
]

export const CAdminNavigation: TCTopNavigation[] = [
  {
    name: 'Manage Groups',
    icon: SquaresPlusIcon,
    href: '/dashboard/manage-groups'
  },
  {
    name: 'Manage Users',
    icon: UsersIcon,
    href: '/dashboard/manage-users'
  },
  {
    name: 'Manage Roles & Permission',
    icon: ShieldCheckIcon,
    href: '/dashboard/manage-roles-permissions'
  },
  {
    name: 'System Settings',
    icon: Cog6ToothIcon,
    href: '/dashboard/system-settings'
  }
]
