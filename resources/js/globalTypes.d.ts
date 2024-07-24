import { FunctionalComponent } from 'vue'
import { PageProps } from '@inertiajs/core'

export interface HeroIcon {
  name: string
  content: string
}

export type CTopNavigation = {
  name: string
  icon?: FunctionalComponent
  href: string
  active?: boolean
  components: string []
}

export type Auth = {
  avatar: string
  created_at: Date
  email: string
  id: string
  name: string
}

export interface Props {
  auth?: Auth
  flash: {
    message: string []
  }
  title: string
  page_title?: string
  sidebar: boolean
  system_settings?: {
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

export interface Pagination<T> {
  current_page: number
  next_page_url: string | null
  data: T []
  total: number
  last_page: number
}

export interface User {
  id: string
  email: string
  avatar: string
  cover: string
  created_at: string
  name: string
  group_members: GroupMember []
  roles: Role []
}

export interface UserWithType extends User {
  type: 'head' |'member'
  disabled: boolean
}

export interface Group {
  id: string
  name: string
  avatar: string
  cover: string
  description: string
  created_at: string
  group_members_admin_only: GroupMember []
  group_members_not_admin_only: GroupMember []
  group_members_not_admin_only_count: number
  group_members: GroupMember []
  task_templates: TaskTemplate []
  tasks: Task[]
}

export interface TaskTemplate {
  id: string
  group_id: string
  group: Group
  task_priority: TaskPriority
  name: string
  description?: string
  is_show: boolean
  task_user_access: TaskAccessUser []
  task_user_access_count: number
}

export interface TaskAccessUser {
  id: string
  user: User
  tasks: Task []
}

export interface TaskPriority {
  id: string
  name: string
  color: string
  hero_icon: HeroIcon
}

export interface GroupMember {
  user?: User
  role?: GroupRole
  group?: Group
  id: string
  group_role_id: string
  group_id: string
  user_id: string
}

export interface GroupRole {
  id: string
  name: string
  description: string
  display_name: string
  hero_icon: HeroIcon
  created_at: string
}

export interface Role {
  id: string
  name: string
  display_name: string
  description: string
  created_at: string
  permissions: Permission []
  users: User []
}

export interface Permission {
  name: string
  display_name: string
  description: string
  id: string
}

export interface Tab {
  display_name: string
  hero_icon: HeroIcon
}

export interface Page extends PageProps {
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
  auth?: Auth

  // NOTE: Independent
  pageTitle: string
}


export interface Filters {
  search: string
  type: string
  page: number
}

export interface Task {
  id: number // no longer uuid
  task_user_access_id: string
  task_priority_id: string
  task_status_id: string
  task_status_at?: Date
  expired_at?: Date
  created_at: Date
  task_user_access: TaskAccessUser
  task_priority: TaskPriority
  task_status: TaskStatus
  task_template: TaskTemplate
  message: string
  user_assigned: User
}

export interface TaskStatus {
  name: string
  hero_icon: HeroIcon
}

export interface Select {
  display_name: string
  id: string
}

export interface Post {
  title: string
  user: User
  created_at: string
  id: string
  is_pinned: number // 0 or 1
  comments: Comment[]
  comments_count: number
  post_type: PostType
  post_contents: PostContent[]
  post_contents_count: number
  reaction_users: ReactionUser[]
  auth_reaction?: ReactionUser
}

export interface ReactionUser {
  id: string
  reaction_id: number
  user_id: string
  reaction: Reaction
  total: number
}

export interface PostType {
  name: string
}

export interface Comment {
  content: string
  user_id: string
  user?: User
  created_at: Date
  id: string
}

export interface PostContent {
  id: string
  name: string
  data_type: string
  file_url: string
  thumbnail_url: string
}

export interface Reaction {
  id: number
  name: string
  content: string
}
