import { h } from 'vue'
import { cn } from '@/lib/utils'

interface SelectProps {
  modelValue: string | number
  placeholder?: string
  disabled?: boolean
}

interface SelectItemProps {
  value: string | number
  disabled?: boolean
}

const Select = {
  name: 'Select',
  props: {
    modelValue: {
      type: [String, Number],
      default: '',
    },
    placeholder: {
      type: String,
      default: 'Select an option',
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
  emits: ['update:modelValue'],
  setup(props: SelectProps, { emit, slots }: { emit: (event: string, value: string) => void, slots: any }) {
    return () => h('select', {
      class: cn(
        'flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50'
      ),
      value: props.modelValue,
      disabled: props.disabled,
      onChange: (e: Event) => {
        const target = e.target as HTMLSelectElement
        emit('update:modelValue', target.value)
      },
    }, [
      h('option', { value: '', disabled: true }, props.placeholder),
      slots.default?.()
    ])
  },
}

const SelectItem = {
  name: 'SelectItem',
  props: {
    value: {
      type: [String, Number],
      required: true,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
  setup(props: SelectItemProps, { slots }: { slots: any }) {
    return () => h('option', {
      value: props.value,
      disabled: props.disabled,
    }, slots.default?.())
  },
}

export {
  Select,
  SelectItem,
} 