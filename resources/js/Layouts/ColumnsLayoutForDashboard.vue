<script setup lang="ts">
import { textMap } from "@/constants/text";
import {
    VApp,
    VAppBar,
    VContainer,
    VMain,
    VNavigationDrawer,
    VResponsive,
} from "vuetify/components";
</script>
<template>
    <VResponsive class="border rounded" max-height="300">
        <VApp>
            <VAppBar :title="textMap.appTitle.long"></VAppBar>

            <VNavigationDrawer>
                <v-list>
                    <v-list-item title="Navigation drawer"></v-list-item>
                </v-list>
            </VNavigationDrawer>

            <VMain>
                <VContainer>
                    <slot></slot>
                </VContainer>
            </VMain>
        </VApp>
    </VResponsive>
</template>
<style scoped></style>
