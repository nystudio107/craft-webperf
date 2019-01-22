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
                  @vuetable:loaded="onLoaded"
        >
            <template slot="page-listing-display" slot-scope="props" :maxValue="maxValue" :triBlend="triBlend">
                <page-result-cell :title="props.rowData.title"
                                  :url="props.rowData.url"
                                  :width="computeWidth(props.rowData.totalPageLoad, maxValue)"
                                  :color="triBlend.colorFromPercentage(((props.rowData.totalPageLoad / maxValue) * 100))"
                >
                </page-result-cell>
            </template>
            <template slot="load-time-bar" slot-scope="props">
                <request-bar-chart :rowData="props.rowData">
                </request-bar-chart>
            </template>
            <template slot="data-samples" slot-scope="props">
                <sample-size-warning :sample="props.rowData.cnt">
                </sample-size-warning>
                {{ props.rowData.cnt }}
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
    import TriBlendColor from '../js/tri-color-blend';
    import RequestBarChart from './RequestBarChart.vue';
    import PageResultCell from './PageResultCell.vue';
    import SampleSizeWarning from './SampleSizeWarning.vue';

    // Our component exports
    export default {
        components: {
            'vuetable': VueTable,
            'vuetable-pagination': VueTablePagination,
            'vuetable-pagination-info': VueTablePaginationInfo,
            'vuetable-filter-bar': VueTableFilterBar,
            'request-bar-chart': RequestBarChart,
            'page-result-cell': PageResultCell,
            'sample-size-warning': SampleSizeWarning,
        },
        props: {
            fastColor: {
                type: String,
                default: '#00C800',
            },
            averageColor: {
                type: String,
                default: '#FFFF00',
            },
            slowColor: {
                type: String,
                default: '#C80000',
            },
            days: {
                type: Number,
                default: 30,
            },
            maxValue: {
                type: Number,
                default: 10000,
            },
            siteId: {
                type: Number,
                default: 0,
            }
        },
        data: function() {
            return {
                moreParams: {
                    'siteId': this.siteId,
                    'days': this.days,
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
                triBlend: new TriBlendColor(this.fastColor, this.averageColor, this.slowColor),
                displayDays: this.days,
            }
        },
        mounted() {
            this.$events.$on('filter-set', eventData => this.onFilterSet(eventData));
            this.$events.$on('filter-reset', e => this.onFilterReset());
            this.$events.$on('change-range', eventData => this.onChangeRange(eventData));
        },
        methods: {
            onFilterSet (filterText) {
                this.moreParams = {
                    'siteId': this.siteId,
                    'days': this.days,
                    'filter': filterText,
                };
                this.$events.fire('refresh-table', this.$refs.vuetable);
            },
            onFilterReset () {
                this.moreParams = {
                    'siteId': this.siteId,
                    'days': this.days,
                };
                this.$events.fire('refresh-table', this.$refs.vuetable);
            },
            onLoaded () {
                this.$events.fire('refresh-table-components', this.$refs.vuetable);
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
                if (dataItem.detailPageUrl.length) {
                    window.location.href = dataItem.detailPageUrl;
                }
            },
            onChangeRange (days) {
                this.displayDays = days;
                this.getSeriesData();
            },
            computeWidth(totalPageLoad, maxValue) {
                let result = ((totalPageLoad / maxValue) * 100);
                if (result > 100) {
                    result = 100;
                }

                return result;
            },
            statFormatter(val) {
                return Number(val / 1000).toFixed(2) + "s";
            },
            countFormatter(val) {
                return Number(val).toFixed(0);
            },
            memoryFormatter(value) {
                return Number(value / (1024 * 1024)).toFixed(2) + ' Mb';
            },
            deleteFormatter(value) {
                if (value === '') {
                    return '';
                }
                return `
                <a class="delete icon" href="${value}" title="Delete"></a>
                `;
            }
        }
    }
</script>
