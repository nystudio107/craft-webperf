<template>
  <apexcharts
    :options="chartOptions"
    :series="series"
    height="200px"
    type="donut"
    width="100%"
  />
</template>

<script>

import Axios from 'axios';
import ApexCharts from 'vue-apexcharts';

const chartDataBaseUrl = '/webperf/charts/widget/';

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
const queryApi = (api, uri, callback) => {
  api.get(uri
  ).then((result) => {
    if (callback) {
      callback(result.data);
    }
  }).catch((error) => {
    console.log(error);
  })
};

// Our component exports
export default {
  components: {
    'apexcharts': ApexCharts,
  },
  props: {
    title: {
      type: String,
      default: '',
    },
    subTitle: {
      type: String,
      default: '',
    },
    days: {
      type: String,
      default: '',
    },
  },
  data: function () {
    return {
      chartOptions: {
        chart: {
          id: 'vuechart-widget',
          toolbar: {
            show: false,
          },
        },
        colors: ['#008FFB', '#DCE6EC'],
        labels: [
          '404 hits',
          '404 hits handled'
        ],
      },
      series: [50, 50],
    }
  },
  created: function () {
    this.getSeriesData();
  },
  methods: {
    // Load in our chart data asynchronously
    getSeriesData: async function () {
      const chartsAPI = Axios.create(configureApi(chartDataBaseUrl));
      await queryApi(chartsAPI, this.days, (data) => {
        this.series = data;
      });
    }
  },
}
</script>
