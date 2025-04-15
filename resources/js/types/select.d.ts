declare module '@/components/ui/select' {
  import { DefineComponent } from 'vue'

  export const Select: DefineComponent<{
    modelValue: string | number
    placeholder?: string
    disabled?: boolean
  }>

  export const SelectItem: DefineComponent<{
    value: string | number
    disabled?: boolean
  }>
} 