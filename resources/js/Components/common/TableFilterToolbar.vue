<script setup lang="ts"></script>
<template>
    <div class="table-toolbar d-flex justify-end align-center pa-2">
        <slot></slot>
    </div>
</template>
<style lang="scss" scoped>
.table-toolbar > *:not(style):not(:last-child) {
    margin-right: 8px;
}
</style>
