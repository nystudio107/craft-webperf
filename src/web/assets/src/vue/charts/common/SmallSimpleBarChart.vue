<template>
  <div class="simple-bar-chart-wrapper px-3 py-1">
    <div class="clearafter py-1">
      <div class="simple-bar-chart-label text-sm font-bold text-gray-600">
        {{ title }}
      </div>
      <div class="simple-bar-chart-value text-sm font-bold text-gray-600">
        {{ statFormatter(series[0]) }}
      </div>
    </div>
    <div class="py-1">
      <div class="simple-bar-chart-track rounded-full bg-gray-300">
        <div
          :style="{ width: series[0] + '%', backgroundColor: barColor }"
          class="simple-bar-line h-1 rounded-full"
        />
      </div>
    </div>
  </div>
</template>

<script>
import Axios from 'axios';
import TriBlendColor from '@/js/tri-color-blend.js';

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
  components: {},
  props: {
    title: {
      type: String,
      default: '',
    },
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
    pageUrl: {
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
      barColor: '#000',
      series: [0],
      displayStart: this.start,
      displayEnd: this.end,
      displayMaxValue: this.maxValue,
      triBlend: new TriBlendColor(this.fastColor, this.averageColor, this.slowColor),
    }
  },
  created() {
    this.getSeriesData();
  },
  mounted() {
    if (this.$events !== undefined) {
      this.$events.$on('change-range', eventData => this.onChangeRange(eventData));
    }
  },
  methods: {
    // Load in our chart data asynchronously
    getSeriesData: async function () {
      const chartsAPI = Axios.create(configureApi(this.apiUrl));
      let params = {
        'column': this.column,
        'start': this.displayStart,
        'end': this.displayEnd,
        'pageUrl': this.pageUrl,
        'siteId': this.siteId,
      };
      await queryApi(chartsAPI, '', params, (data) => {
        if (data.avg !== undefined) {
          let val = data.avg / 1000;
          if (val > this.displayMaxValue) {
            this.displayMaxValue = val;
          }
          val = (val * 100) / this.displayMaxValue;
          this.barColor = this.triBlend.colorFromPercentage(val);
          this.series = [val];
        }
      });
    },
    onChangeRange(range) {
      this.displayStart = range.start;
      this.displayEnd = range.end;
      this.getSeriesData();
    },
    statFormatter(val) {
      val = (val * this.displayMaxValue) / 100;
      return Number(val).toFixed(2) + "s";
    }
  },
}
</script>
