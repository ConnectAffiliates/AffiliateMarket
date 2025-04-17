<script setup lang="ts">
defineOptions({
    name: 'TableHeader',
});
</script>

<template>
    <thead class="[&_tr]:border-b">
        <slot />
    </thead>
</template> 