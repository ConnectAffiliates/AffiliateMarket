<script setup lang="ts">
import { provide, ref } from 'vue';

defineOptions({
    name: 'Tabs',
});

interface Props {
    defaultValue?: string;
}

const props = withDefaults(defineProps<Props>(), {
    defaultValue: '',
});

const activeTab = ref(props.defaultValue);

provide('activeTab', activeTab);
</script>

<template>
    <div class="w-full">
        <slot />
    </div>
</template> 