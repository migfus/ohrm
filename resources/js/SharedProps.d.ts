import { User } from "./globalTypes"

interface SharedProps{
  title: string
  sidebar: boolean
  logo: {
    lg: string
    sm: string
  }
  pageTitle: string
  flash?: {
    error: {
      title: string
      content: string
    }
    success: {
      title: string
      content: string
    }
  }
  auth?: User

  [key: string]: any
}

export default SharedProps
