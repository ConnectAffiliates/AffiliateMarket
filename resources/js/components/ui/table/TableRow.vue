<script setup lang="ts">
defineOptions({
    name: 'TableRow',
});
</script>

<template>
    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
        <slot />
    </tr>
</template> 