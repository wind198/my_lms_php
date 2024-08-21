<script setup lang="ts">
import { DefaultTablePerPageItems } from "@/constants";
import type { IServerTableParams } from "@/types/common/server-table.type";
import type { IEntity } from "@/types/entities/entity.type";
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash-es";
import { computed } from "vue";

type IProps<T> = {
    data: T[];
    params: IServerTableParams<T>;
    headers: any[];
    hideSearch?: boolean;
};

const props = defineProps<IProps<IEntity>>();

const paginationText = computed(() => {
    const startItemIndex =
        (props.params.current_page - 1) * props.params.per_page + 1;
    const endItemIndex = props.params.current_page * props.params.per_page;
    const totalItems = props.params.total;
    return `${startItemIndex} to ${endItemIndex} of ${totalItems}`;
});

const handleChangePage = (v: number) => {
    emitEvent("update-per-page", v);
};

const handleChangePerPage = (v: number) => {
    emitEvent("update-per-page", v);
};
const handleChangeOrder = (key: string) => {
    const match = props.headers.find((i) => i.value === key);
    if(!match) {return }

    const newOrder =
        key === props.params.order_by
            ? props.params.order === "desc"
                ? "asc"
                : "desc"
            : "asc";
    emitEvent("update-order-by", { orderBy: key, order: newOrder });
};

const emitEvent = defineEmits([
    "search",
    "update-page",
    "update-per-page",
    "update-order-by",
]);

const handleSearch = debounce((v: string) => {
    emitEvent("search", v);
}, 500);
</script>
<template>
    <VDataTable
        :items="props.data"
        :headers="props.headers"
        :hide-default-footer="true"
        :items-per-page="params.per_page"
    >
        <template v-slot:top="{}">
            <div class="table-toolbar d-flex justify-end align-center pa-2">
                <VTextField
                    v-if="!props.hideSearch"
                    clearable
                    hide-details="auto"
                    density="compact"
                    variant="outlined"
                    class="search-field mr-2 flex-grow-0"
                    dense
                    v-model="params.filters.q"
                    prepend-inner-icon="mdi-magnify"
                    @update:model-value="handleSearch($event)"
                ></VTextField>
                <slot name="filters"></slot>
            </div>
        </template>
        <template v-slot:headers="{ columns }">
            <tr>
                <template v-for="column in columns" :key="column.key">
                    <th
                        @click="handleChangeOrder(column.key)"
                        :class="
                            [
                                `head-cell-${column.key}`,
                                `text-${column.align ?? 'left'}`,
                                column.sortable ? 'cursor-pointer' : '',
                            ].join(' ')
                        "
                    >
                        {{ column.title }}
                        <VIcon v-if="params.order_by === column.key">
                            {{
                                params.order === "desc"
                                    ? "mdi-arrow-down"
                                    : "mdi-arrow-up"
                            }}
                        </VIcon>
                    </th>
                </template>
            </tr></template
        >
    </VDataTable>
    <div class="d-flex justify-end">
        <span class="mb-0 text-body-2 align-self-center mr-4"
            >{{ paginationText }}
        </span>
        <VSelect
            label="Per page"
            class="flex-grow-0 item-per-page-select"
            :model-value="params.per_page"
            @update:model-value="handleChangePerPage"
            :items="DefaultTablePerPageItems"
        >
        </VSelect>
        <VPagination
            :model-value="params.current_page"
            :length="params.last_page"
            @update:model-value="handleChangePage"
            :total-visible="5"
        ></VPagination>
    </div>
</template>
<style scoped></style>
