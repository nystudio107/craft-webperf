<template>
  <div class="py-4">
    <vuetable-filter-bar />
    <div class="vuetable-pagination clearafter">
      <vuetable-pagination-info
        ref="paginationInfoTop"
        info-template="Displaying {from} to {to} of {total} data samples"
      />
      <vuetable-pagination
        ref="paginationTop"
        @vuetable-pagination:change-page="onChangePage"
      />
    </div>
    <div class="overflow-x-auto overflow-y-hidden">
      <vuetable
        ref="vuetable"
        :api-url="apiUrl"
        :append-params="moreParams"
        :css="css"
        :fields="fields"
        :per-page="20"
        :sort-order="sortOrder"
        @vuetable:pagination-data="onPaginationData"
        @vuetable:row-clicked="onRowClicked"
        @vuetable:loaded="onLoaded"
      >
        <template
          slot="error-date"
          slot-scope="props"
        >
          <data-sample-date
            :date="props.rowData.dateCreated"
            :query="props.rowData.query"
            :url="props.rowData.url"
          />
        </template>
        <template
          slot="error-sample"
          slot-scope="props"
        >
          <error-sample
            :page-errors="props.rowData.pageErrors"
            :type="props.rowData.type"
          />
        </template>
        <template
          slot="sample-device"
          slot-scope="props"
        >
          <data-sample-device
            :device="props.rowData.device"
            :mobile="props.rowData.mobile"
          />
        </template>
        <template
          slot="load-time-bar"
          slot-scope="props"
        >
          <request-bar-chart :row-data="props.rowData" />
        </template>
      </vuetable>
    </div>
    <div class="vuetable-pagination clearafter">
      <vuetable-pagination-info
        ref="paginationInfo"
        info-template="Displaying {from} to {to} of {total} data samples"
      />
      <vuetable-pagination
        ref="pagination"
        @vuetable-pagination:change-page="onChangePage"
      />
    </div>
  </div>
</template>

<script>
import FieldDefs from '@/vue/tables/errors/ErrorsDetailFieldDefs.js';
import VueTable from 'vuetable-2/src/components/Vuetable.vue';
import VueTablePagination from '@/vue/tables/common/VuetablePagination.vue';
import VueTablePaginationInfo from '@/vue/tables/common/VuetablePaginationInfo.vue';
import VueTableFilterBar from '@/vue/tables/common/VuetableFilterBar.vue';
import RequestBarChart from '@/vue/charts/common/RequestBarChart.vue';
import PageResultCell from '@/vue/tables/common/PageResultCell.vue';
import DataSampleDate from '@/vue/tables/common/DataSampleDate.vue';
import DataSampleDevice from '@/vue/tables/common/DataSampleDevice.vue';
import ErrorSample from '@/vue/tables/errors/ErrorSample.vue';

// Our component exports
export default {
  components: {
    'vuetable': VueTable,
    'vuetable-pagination': VueTablePagination,
    'vuetable-pagination-info': VueTablePaginationInfo,
    'vuetable-filter-bar': VueTableFilterBar,
    'request-bar-chart': RequestBarChart,
    // eslint-disable-next-line vue/no-unused-components
    'page-result-cell': PageResultCell,
    'data-sample-date': DataSampleDate,
    'data-sample-device': DataSampleDevice,
    'error-sample': ErrorSample,
  },
  props: {
    start: {
      type: String,
      default: '',
    },
    end: {
      type: String,
      default: '',
    },
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
    pageUrl: {
      type: String,
      default: '',
    },
    siteId: {
      type: Number,
      default: 0,
    },
    apiUrl: {
      type: String,
      default: '',
    },
  },
  data: function () {
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
    this.$events.$on('filter-reset', () => this.onFilterReset());
    this.$events.$on('change-range', eventData => this.onChangeRange(eventData));
  },
  methods: {
    onFilterSet(filterText) {
      this.moreParams.filter = filterText;
      this.$events.fire('refresh-table', this.$refs.vuetable);
    },
    onFilterReset() {
      this.moreParams.filter = '';
      this.$events.fire('refresh-table', this.$refs.vuetable);
    },
    onLoaded() {
      this.$events.fire('refresh-table-components', this.$refs.vuetable);
    },
    onPaginationData(paginationData) {
      this.$refs.paginationTop.setPaginationData(paginationData);
      this.$refs.paginationInfoTop.setPaginationData(paginationData);

      this.$refs.pagination.setPaginationData(paginationData);
      this.$refs.paginationInfo.setPaginationData(paginationData);
    },
    onChangePage(page) {
      this.$refs.vuetable.changePage(page);
    },
    onRowClicked() {
      console.log();
    },
    onChangeRange(range) {
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
