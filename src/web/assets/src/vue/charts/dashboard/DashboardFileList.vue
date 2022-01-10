<template>
  <section class="px-3 py-3">
    <div class="text-left text-base font-bold px-2 pt-2">
      Slowest pages
    </div>
    <div
      v-for="(item, index) in series"
      :key="index"
      class="file-list-wrapper p-2"
    >
      <dashboard-file-list-cell
        :cnt="item.cnt"
        :color="item.barColor"
        :data="statFormatter(item.data, item.maxValue)"
        :detail-page-url="item.detailPageUrl"
        :title="item.title"
        :url="item.url"
        :width="item.data"
      />
    </div>
  </section>
</template>

<script>
import Axios from 'axios';
import TriBlendColor from '@/js/tri-color-blend.js';
import DashboardFileListCell from '@/vue/charts/dashboard/DashboardFileListCell.vue';

// Configure the api endpoint
const configureApi = (url) => {
  return {
    baseURL: url,
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  };
};
// Query our API endpoint via an XHR GET
const queryApi = (api, uri, params, callback) => {
  api.get(uri, {params: params})
    .then((result) => {
      if (callback) {
        callback(result.data);
      }
    })
    .catch((error) => {
      console.log(error);
    })
};

// Our component exports
export default {
  name: 'DashboardFileList',
  components: {
    'dashboard-file-list-cell': DashboardFileListCell,
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
    column: {
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
    limit: {
      type: Number,
      default: 3,
    },
    maxValue: Number,
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
      series: [],
      displayStart: this.start,
      displayEnd: this.end,
      triBlend: new TriBlendColor(this.fastColor, this.averageColor, this.slowColor),
    }
  },
  created() {
    this.getSeriesData();
  },
  mounted() {
    this.$events.$on('change-range', eventData => this.onChangeRange(eventData));
  },
  methods: {
    // Load in our chart data asynchronously
    getSeriesData: async function () {
      const chartsAPI = Axios.create(configureApi(this.apiUrl));
      let params = {
        'column': this.column,
        'start': this.displayStart,
        'end': this.displayEnd,
        'siteId': this.siteId,
      };
      await queryApi(chartsAPI, '', params, (data) => {
        data.forEach((element, index, array) => {
          let val = element.avg / 1000;
          let maxValue = this.maxValue;
          if (val > maxValue) {
            maxValue = val;
          }
          val = (val * 100) / maxValue;
          array[index].data = val;
          array[index].maxValue = maxValue;
          array[index].barColor = this.triBlend.colorFromPercentage(val);
        });
        this.series = data;
      });
    },
    onChangeRange(range) {
      this.displayStart = range.start;
      this.displayEnd = range.end;
      this.getSeriesData();
    },
    statFormatter(val, maxValue) {
      val = (val * maxValue) / 100;
      return Number(val).toFixed(2) + "s";
    }
  },
}
</script>
