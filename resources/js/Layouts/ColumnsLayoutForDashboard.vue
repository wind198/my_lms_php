<script setup lang="ts">
import { textMap } from "@/constants/text";
import {
    VApp,
    VAppBar,
    VContainer,
    VList,
    VMain,
    VNavigationDrawer,
    VResponsive,
    VListItem,
    VListItemTitle,
} from "vuetify/components";
import { Link } from "@inertiajs/vue3";
import { concatClasses } from "@/helper";
import { AppLinkClasses, NavLinkClasses } from "@/constants";

const settingLinks = [
    { to: "/settings/students", text: "Students", value: "students" },
    { to: "/settings/teachers", text: "Teachers", value: "teachers" },
];
</script>
<template>
    <VResponsive class="border rounded">
        <VApp>
            <VAppBar :title="textMap.appTitle.long"></VAppBar>

            <VNavigationDrawer>
                <div class="d-flex flex-column py-2">
                    <div
                        v-for="link in settingLinks"
                        :key="link.value"
                        v-ripple
                    >
                        <Link
                            :class="
                                concatClasses(
                                    NavLinkClasses.concat(
                                        'px-3',
                                        'py-2',
                                        'd-block'
                                    )
                                )
                            "
                            :href="link.to"
                            v-ripple
                            >{{ link.text }}
                        </Link>
                    </div>
                </div>
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
