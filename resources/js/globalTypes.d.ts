import { FunctionalComponent } from 'vue'
import { PageProps } from '@inertiajs/core'

export interface THeroIcon {
  name: string
  content: string
}

export type TCTopNavigation = {
  name: string
  icon?: FunctionalComponent
  href: string
  active?: boolean
  components: string []
}

export type GTAuth = {
  avatar: string
  created_at: Date
  email: string
  id: string
  name: string
}

export interface TProps {
  auth?: GTAuth
  flash: {
    message: string []
  }
  title: string
  pageTitle: string
  sidebar: boolean
  system_settings: {
    name: string
    config: string
    description: string
  } []
  data?: object
  errors?: object
  logo: {
    lg: string
    sm: string
  }
}

export interface TPagination<T> {
  current_page: number
  data: T []
  total: number
}

export interface TUser {
  id: string
  email: string
  avatar: string
  cover: string
  created_at: string
  name: string
  group_members: TGroupMember []
  roles: TRole []
}

export interface TUserWithType extends TUser {
  type: 'head' |'member'
  disabled: boolean
}

export interface TGroup {
  id: string
  name: string
  avatar: string
  cover: string
  description: string
  created_at: string
  group_members_admin_only: TGroupMember []
  group_members_not_admin_only: TGroupMember []
  group_members_not_admin_only_count: number
  group_members: TGroupMember []
  task_templates: TTaskTemplate []
}

export interface TTaskTemplate {
  id: string
  group_id: string
  group: TGroup
  task_priority: TTaskPriority
  name: string
  description?: string
  is_show: boolean
  task_user_access: TTaskAccessUser []
  task_user_access_count: number
}

export interface TTaskAccessUser {
  id: string
  user: TUser
  tasks: TTask []
}

export interface TTaskPriority {
  id: string
  name: string
  color: string
  hero_icon: THeroIcon
}

export interface TGroupMember {
  user?: TUser
  role?: TGroupRole
  group?: TGroup
  id: string
  group_role_id: string
  group_id: string
  user_id: string
}

export interface TGroupRole {
  id: string
  name: string
  description: string
  display_name: string
  hero_icon: THeroIcon
  created_at: string
}

export interface TRole {
  id: string
  name: string
  display_name: string
  description: string
  created_at: string
  permissions: TPermission []
  users: TUser []
}

export interface TPermission {
  name: string
  display_name: string
  description: string
  id: string
}

export interface TTab {
  display_name: string
  hero_icon: THeroIcon
}

export interface TPage extends PageProps {
  // NOTE: Shared
  title: string
  sidebar: boolean
  logo: {
    sm: string
    lg: string
  }
  flash?: {
    error?: string
    success?: string
  }
  auth?: GTAuth

  // NOTE: Independent
  pageTitle: string
}


export interface TFilters {
  search: string
  type: string
  page: number
}

export interface TTask {
  id: number // no longer uuid
  task_user_access_id: string
  task_priority_id: string
  task_status_id: string
  task_status_at?: Date
  expired_at?: Date
  created_at: Date
  task_user_access: TTaskAccessUser
  task_priority: TTaskPriority
  task_status: TTaskStatus
}

export interface TTaskStatus {
  name: string
  hero_icon: THeroIcon
}

export interface TSelect {
  display_name: string
  id: string
}
