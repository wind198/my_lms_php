<script setup lang="ts">
import { debounce } from "lodash-es";
import { VTextField } from "vuetify/components";

const modelValue = defineModel();

const emit = defineEmits(["debounce-change"]);

const handleUpdateModelValue = debounce((v: string) => {
    emit("debounce-change", v);
}, 500);
</script>
<template>
    <VTextField
        clearable
        hide-details="auto"
        density="compact"
        variant="outlined"
        class="search-field flex-grow-0"
        dense
        v-model="modelValue"
        prepend-inner-icon="mdi-magnify"
        @update:model-value="handleUpdateModelValue($event)"
    ></VTextField>
</template>
<style scoped>
.search-field {
    min-width: 240px;
}
</style>
