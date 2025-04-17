<script setup lang="ts">
import { inject, computed } from 'vue';

defineOptions({
    name: 'TabsTrigger',
});

interface Props {
    value: string;
    disabled?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    disabled: false,
});

const activeTab = inject('activeTab', { value: '' });

const isActive = computed(() => activeTab.value === props.value);

const handleClick = () => {
    if (!props.disabled) {
        activeTab.value = props.value;
    }
};
</script>

<template>
    <button
        type="button"
        role="tab"
        :aria-selected="isActive"
        :data-state="isActive ? 'active' : 'inactive'"
        :disabled="disabled"
        class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm"
        @click="handleClick"
    >
        <slot />
    </button>
</template> 