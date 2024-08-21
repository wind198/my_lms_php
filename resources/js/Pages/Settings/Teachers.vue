<script lang="ts">
export default {
    layout: (h, page) =>
        h(ColumnsLayoutForDashboard, () => h(SettingsLayout, () => page)),
};
</script>
<script setup lang="ts">
import ColumnsLayoutForDashboard from "@/Layouts/ColumnsLayoutForDashboard.vue";
import SettingsLayout from "@/Layouts/SettingsLayout.vue";
import { textMap } from "@/constants/text";
import { datetimeFormater } from "@/helper/formatter";
import type { IUser } from "@/types/entities/user.type";
import { cloneDeep, debounce, set } from "lodash-es";
import { stringify } from "qs";
import { reactive } from "vue";
import { VDataTable, VIcon } from "vuetify/components";
import { AppLinkClasses, DefaultTablePerPage } from "../../constants";

import ServerTablePagination from "@/Components/common/ServerTablePagination.vue";
import TableSearchField from "@/Components/common/TableSearchField.vue";
import { router } from "@inertiajs/vue3";
import dayjs from "dayjs";
import AppDateSelectorMenu from "../../Components/common/AppDateSelectorMenu.vue";
import { concatClasses, removeValueFromObject } from "../../helper";
import type { IServerTableParams } from "../../types/common/server-table.type";
import ServerTableHeadCell from "@/Components/common/ServerTableHeadCell.vue";
import TableFilterToolbar from "@/Components/common/TableFilterToolbar.vue";
import useServerTable from "@/hooks/useServerTable";
type IProps = {
    data: IUser[];
    params: IServerTableParams<IUser>;
};

const props = defineProps<IProps>();

const headers = [
    {
        title: textMap.nouns.fullName,
        value: "full_name",
        sortable: true,
        align: "center",
    },
    {
        title: textMap.nouns.created_at,
        value: "created_at",
        sortable: true,
        align: "center",
    },
    {
        title: textMap.nouns.email,
        value: "email",
        sortable: true,
        align: "center",
    },
    {
        title: textMap.nouns.phone,
        value: "phone",
        sortable: true,
        align: "center",
    },
];

const {
    handleChangeFilter,
    handleChangeOrder,
    handleChangePage,
    handleChangePerPage,
} = useServerTable({
    data: props.data,
    headers,
    params: props.params as any,
});

const onChangeFilter = (v: any, keys: string[]) => {
    let newFilters = cloneDeep(props.params.filters);

    //  update filter value
    let formatedValue = v;
    if (keys[0] === "created_at" && keys[1] === "gte") {
        if (v) {
            formatedValue = dayjs(v).startOf("day").toISOString();
        }
    } else if (keys[0] === "created_at" && keys[1] === "lte") {
        if (v) {
            formatedValue = dayjs(v).endOf("day").toISOString();
        }
    }
    set(newFilters, keys, formatedValue);

    // clear invalid filter values
    newFilters = removeValueFromObject(
        newFilters,
        (i: any) => i === undefined || (typeof i === "string" && !i.trim())
    );

    handleChangeFilter(newFilters);
};
</script>
<template>
    <h1 class="text-h6 text-lowercase text-cap-first">
        {{ textMap.nouns.list({ item: textMap.nouns.teacher }) }}
    </h1>
    <div class="teacher-list">
        <VDataTable
            :items="props.data"
            :headers="headers as any"
            :hide-default-footer="true"
            :items-per-page="props.params.per_page"
        >
            <template v-slot:top="{}">
                <TableFilterToolbar>
                    <TableSearchField
                        v-model="props.params.filters.q"
                        @debounce-change="onChangeFilter($event, ['q'])"
                    ></TableSearchField>
                    <AppDateSelectorMenu
                        class="date-selector"
                        v-model="(props.params.filters.created_at || {}).gte"
                        :label="textMap.verbs.createAfter"
                        @update:model-value="
                            onChangeFilter($event, ['created_at', 'gte'])
                        "
                    ></AppDateSelectorMenu>
                </TableFilterToolbar>
            </template>
            <template v-slot:headers="{ columns }">
                <tr>
                    <template v-for="column in columns" :key="column.key">
                        <ServerTableHeadCell
                            :value="column.key"
                            :sortable="column.sortable"
                            :current-order="props.params.order"
                            :is-active="props.params.order_by === column.key"
                            :align="column.align"
                            :title="column.title"
                            @click="handleChangeOrder($event)"
                        ></ServerTableHeadCell>
                    </template></tr
            ></template>
            <template v-slot:item.created_at="{ value }">
                {{ datetimeFormater.standard(value) }}
            </template>
            <template v-slot:item.email="{ value }">
                <a
                    :class="concatClasses(AppLinkClasses)"
                    :href="`mailto:${value}`"
                    >{{ value }}</a
                >
            </template>
            <template v-slot:item.phone="{ value }">
                <a
                    :class="concatClasses(AppLinkClasses)"
                    :href="`tel:${value}`"
                    >{{ value }}</a
                >
            </template>
        </VDataTable>
        <ServerTablePagination
            @update-page="handleChangePage"
            @update-per-page="handleChangePerPage"
            :length="props.params.last_page"
            :page="props.params.current_page"
            :per-page="props.params.per_page"
            :total-items="props.params.total"
        ></ServerTablePagination>
    </div>
</template>

<style scoped>
.date-selector {
    min-width: 240px;
}
</style>
