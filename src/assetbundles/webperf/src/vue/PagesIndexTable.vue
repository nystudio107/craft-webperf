<template>
    <div class="py-4">
        <vuetable-filter-bar></vuetable-filter-bar>
        <div class="vuetable-pagination clearafter">
            <vuetable-pagination-info ref="paginationInfoTop"
            ></vuetable-pagination-info>
            <vuetable-pagination ref="paginationTop"
                                 @vuetable-pagination:change-page="onChangePage"
            ></vuetable-pagination>
        </div>
        <vuetable ref="vuetable"
                  api-url="/webperf/tables/pages-index"
                  :per-page="20"
                  :fields="fields"
                  :css="css"
                  :sort-order="sortOrder"
                  :append-params="moreParams"
                  @vuetable:pagination-data="onPaginationData"
                  @vuetable:row-clicked="onRowClicked"
        >
            <template slot="load-time-bar" slot-scope="props">
                <div>
                    <div class="inline-block align-middle" style="width: 80%">
                        <div class="bg-blue-dark h-5"
                             :style="{width: ((props.rowData.totalPageLoad / props.rowData.maxTotalPageLoad) * 100) + '%'}"
                             title="Page Load"
                        >
                            <div class="bg-orange h-5"
                                 :style="{width: ((props.rowData.domInteractive / props.rowData.totalPageLoad) * 100) + '%'}"
                                 title="DOM Interactive"
                            >
                                <div class="bg-red h-5"
                                     :style="{width: ((props.rowData.firstContentfulPaint / props.rowData.domInteractive) * 100) + '%'}"
                                     title="First Contentful Paint"
                                >
                                    <div class="bg-yellow h-5"
                                         :style="{width: ((props.rowData.firstPaint / props.rowData.firstContentfulPaint) * 100) + '%'}"
                                         title="First Paint"
                                    >
                                        <div class="bg-green h-5"
                                             :style="{width: ((props.rowData.firstByte / props.rowData.firstPaint) * 100) + '%'}"
                                             title="First Byte"
                                        >
                                            <div class="bg-red-dark h-5"
                                                 :style="{width: ((props.rowData.craftTotalMs / props.rowData.firstByte) * 100) + '%'}"
                                                 title="Craft Rendering"
                                            >
                                                <div v-if="props.rowData.craftDbMs > props.rowData.craftTwigMs" class="bg-purple h-5"
                                                     :style="{width: ((props.rowData.craftDbMs / props.rowData.craftTotalMs) * 100) + '%'}"
                                                     title="DB Queries"
                                                >
                                                    <div class="bg-yellow-dark h-5"
                                                         :style="{width: ((props.rowData.craftTwigMs / props.rowData.craftDbMs) * 100) + '%'}"
                                                         title="Template Rendering"
                                                    >
                                                    </div>
                                                </div>
                                                <div v-else class="bg-yellow-dark h-5"
                                                     :style="{width: ((props.rowData.craftTwigMs / props.rowData.craftTotalMs) * 100) + '%'}"
                                                     title="Template Rendering"
                                                >
                                                    <div class="bg-purple h-5"
                                                         :style="{width: ((props.rowData.craftDbMs / props.rowData.craftTwigMs) * 100) + '%'}"
                                                         title="DB Queries"
                                                    >
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="align-middle">{{ statFormatter(props.rowData.totalPageLoad) }}</span>
                </div>
            </template>
            <template slot="page-listing-display" slot-scope="props">
                <div>
                    <div class="relative single-line-truncate-wrapper">
                        <div class="text-base font-normal truncate-label"
                             style="color: rgb(26, 13, 171); width: 100%; height: 20px;"
                             :title="props.rowData.title"
                        >
                            <span v-if="props.rowData.title">{{ props.rowData.title }}</span>
                            <span v-else class="text-grey-light"><em>untitled</em></span>

                        </div>
                    </div>
                    <div class="relative single-line-truncate-wrapper">
                        <cite class="text-sm font-normal truncate-label single-line-truncate"
                              style="color: rgb(0, 102, 33); width: 100%; "
                              :title="props.rowData.url"
                        >
                            {{ props.rowData.url }}
                        </cite>
                    </div>
                </div>
            </template>
        </vuetable>
        <div class="vuetable-pagination clearafter">
            <vuetable-pagination-info ref="paginationInfo"
            ></vuetable-pagination-info>
            <vuetable-pagination ref="pagination"
                                 @vuetable-pagination:change-page="onChangePage"
            ></vuetable-pagination>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import FieldDefs from './PagesIndexFieldDefs.js';
    import VueTable from 'vuetable-2/src/components/Vuetable.vue';
    import VueTablePagination from './VuetablePagination.vue';
    import VueTablePaginationInfo from './VuetablePaginationInfo.vue';
    import VueTableFilterBar from './VuetableFilterBar.vue';

    // Our component exports
    export default {
        components: {
            'vuetable': VueTable,
            'vuetable-pagination': VueTablePagination,
            'vuetable-pagination-info': VueTablePaginationInfo,
            'vuetable-filter-bar': VueTableFilterBar,
        },
        props: {
            siteId: {
                type: Number,
                default: 0,
            }
        },
        data: function() {
            return {
                moreParams: {
                    'siteId': this.siteId,
                },
                css: {
                    tableClass: 'data fullwidth webperf-pages-index',
                    ascendingIcon: 'menubtn webperf-menubtn-asc',
                    descendingIcon: 'menubtn webperf-menubtn-desc'
                },
                sortOrder: [
                    {
                        field: '__slot:load-time-bar',
                        sortField: 'totalPageLoad',
                        direction: 'desc'
                    }
                ],
                fields: FieldDefs,
            }
        },
        mounted() {
            this.$events.$on('filter-set', eventData => this.onFilterSet(eventData));
            this.$events.$on('filter-reset', e => this.onFilterReset());
        },
        methods: {
            onFilterSet (filterText) {
                this.moreParams = {
                    'siteId': this.siteId,
                    'filter': filterText,
                };
                this.$events.fire('refresh-table', this.$refs.vuetable);
            },
            onFilterReset () {
                this.moreParams = {
                    'siteId': this.siteId,
                };
                this.$events.fire('refresh-table', this.$refs.vuetable);
            },
            onPaginationData (paginationData) {
                this.$refs.paginationTop.setPaginationData(paginationData);
                this.$refs.paginationInfoTop.setPaginationData(paginationData);

                this.$refs.pagination.setPaginationData(paginationData);
                this.$refs.paginationInfo.setPaginationData(paginationData);
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page);
            },
            onRowClicked(dataItem, event) {
                console.log(dataItem);
            },
            statFormatter(val) {
                return Number(val / 1000).toFixed(2) + "s";
            },
            countFormatter(val) {
                return Number(val).toFixed(0);
            },
            memoryFormatter(value) {
                return Number(value / (1024 * 1024)).toFixed(2) + ' Mb';
            }
        }
    }
</script>
