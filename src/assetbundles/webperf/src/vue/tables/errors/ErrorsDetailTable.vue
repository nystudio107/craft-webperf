<template>
    <div class="py-4">
        <vuetable-filter-bar></vuetable-filter-bar>
        <div class="vuetable-pagination clearafter">
            <vuetable-pagination-info ref="paginationInfoTop"
                                      infoTemplate="Displaying {from} to {to} of {total} data samples"
            ></vuetable-pagination-info>
            <vuetable-pagination ref="paginationTop"
                                 @vuetable-pagination:change-page="onChangePage"
            ></vuetable-pagination>
        </div>
        <div class="overflow-x-auto overflow-y-hidden">
            <vuetable ref="vuetable"
                      :api-url=apiUrl
                      :per-page="20"
                      :fields="fields"
                      :css="css"
                      :sort-order="sortOrder"
                      :append-params="moreParams"
                      @vuetable:pagination-data="onPaginationData"
                      @vuetable:row-clicked="onRowClicked"
                      @vuetable:loaded="onLoaded"
            >
                <template slot="error-date" slot-scope="props">
                    <data-sample-date :date="props.rowData.dateCreated"
                                      :url="props.rowData.url"
                                      :query="props.rowData.query"
                    >
                    </data-sample-date>
                </template>
                <template slot="error-sample" slot-scope="props">
                    <error-sample :page-errors="props.rowData.pageErrors"
                                      :type="props.rowData.type"
                    >
                    </error-sample>
                </template>
                <template slot="sample-device" slot-scope="props">
                    <data-sample-device :mobile="props.rowData.mobile"
                                      :device="props.rowData.device"
                    >
                    </data-sample-device>
                </template>
                <template slot="load-time-bar" slot-scope="props">
                    <request-bar-chart :rowData="props.rowData">
                    </request-bar-chart>
                </template>
            </vuetable>
        </div>
        <div class="vuetable-pagination clearafter">
            <vuetable-pagination-info ref="paginationInfo"
                                      infoTemplate="Displaying {from} to {to} of {total} data samples"
            ></vuetable-pagination-info>
            <vuetable-pagination ref="pagination"
                                 @vuetable-pagination:change-page="onChangePage"
            ></vuetable-pagination>
        </div>
    </div>
</template>

<script>
    import FieldDefs from './ErrorsDetailFieldDefs.js';
    import VueTable from 'vuetable-2/src/components/Vuetable.vue';
    import VueTablePagination from '../common/VuetablePagination.vue';
    import VueTablePaginationInfo from '../common/VuetablePaginationInfo.vue';
    import VueTableFilterBar from '../common/VuetableFilterBar.vue';
    import RequestBarChart from '../../charts/common/RequestBarChart.vue';
    import PageResultCell from '../common/PageResultCell.vue';
    import DataSampleDate from '../common/DataSampleDate.vue';
    import DataSampleDevice from '../common/DataSampleDevice.vue';
    import ErrorSample from './ErrorSample.vue';

    // Our component exports
    export default {
        components: {
            'vuetable': VueTable,
            'vuetable-pagination': VueTablePagination,
            'vuetable-pagination-info': VueTablePaginationInfo,
            'vuetable-filter-bar': VueTableFilterBar,
            'request-bar-chart': RequestBarChart,
            'page-result-cell': PageResultCell,
            'data-sample-date': DataSampleDate,
            'data-sample-device': DataSampleDevice,
            'error-sample': ErrorSample,
        },
        props: {
            start: String,
            end: String,
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
            maxValue: {
                type: Number,
                default: 10000,
            },
            pageUrl: String,
            siteId: {
                type: Number,
                default: 0,
            },
            apiUrl: {
                type: String,
                default: '',
            },
        },
        data: function() {
            return {
                moreParams: {
                    'siteId': this.siteId,
                    'pageUrl': this.pageUrl,
                    'start': this.start,
                    'end': this.end,
                    'filter': '',
                },
                css: {
                    tableClass: 'data fullwidth webperf-page-detail',
                    ascendingIcon: 'menubtn webperf-menubtn-asc',
                    descendingIcon: 'menubtn webperf-menubtn-desc'
                },
                sortOrder: [
                    {
                        field: '__slot:error-date',
                        sortField: 'dateCreated',
                        direction: 'desc'
                    }
                ],
                fields: FieldDefs,
            }
        },
        mounted() {
            this.$events.$on('filter-set', eventData => this.onFilterSet(eventData));
            this.$events.$on('filter-reset', e => this.onFilterReset());
            this.$events.$on('change-range', eventData => this.onChangeRange(eventData));
        },
        methods: {
            onFilterSet (filterText) {
                this.moreParams.filter = filterText;
                this.$events.fire('refresh-table', this.$refs.vuetable);
            },
            onFilterReset () {
                this.moreParams.filter = '';
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
            },
            onChangeRange (range) {
                this.moreParams.start = range.start;
                this.moreParams.end = range.end;
                this.$events.fire('refresh-table', this.$refs.vuetable);
            },
            statFormatter(val) {
                return Number(val / 1000).toFixed(2) + "s";
            },
            countFormatter(val) {
                return Number(val).toFixed(0);
            },
            memoryFormatter(val) {
                return Number(val / (1024 * 1024)).toFixed(2) + ' Mb';
            },
            dateFormatter(val) {
                return val;
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
