<script setup lang="ts">
import { inject, computed } from 'vue';

defineOptions({
    name: 'TabsContent',
});

interface Props {
    value: string;
}

const props = defineProps<Props>();

const activeTab = inject('activeTab', { value: '' });

const isActive = computed(() => activeTab.value === props.value);
</script>

<template>
    <div
        role="tabpanel"
        :data-state="isActive ? 'active' : 'inactive'"
        class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
        :class="{ 'hidden': !isActive }"
    >
        <slot />
    </div>
</template> 