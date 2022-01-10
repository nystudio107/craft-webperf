<template>
  <apexcharts
    :options="chartOptions"
    :series="series"
    height="450px"
    type="area"
    width="100%"
  />
</template>

<script>
import Axios from 'axios';
import ApexCharts from 'vue-apexcharts';

// Get the largest number from the passed in arrays
const largestNumber = (mainArray) => {
  return mainArray.map(function (subArray) {
    return Math.max.apply(null, subArray);
  });
};

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
  components: {
    'apexcharts': ApexCharts,
  },
  props: {
    title: String,
    start: String,
    end: String,
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
      chartOptions: {
        chart: {
          id: 'vuechart-pages-detail',
          toolbar: {
            show: false,
          },
          sparkline: {
            enabled: false
          },
          animations: {
            enabled: false,
          },
        },
        tooltip: {
          enabled: true,
          inverseOrder: true,
          x: {
            show: false,
          },
        },
        colors: [
          '#1F9D55',
          '#CC1F1A',
        ],
        stroke: {
          curve: 'smooth',
          width: 3,
        },
        fill: {
          type: 'solid',
          opacity: 0.5,
          gradient: {
            enabled: false,
          },
        },
        legend: {
          formatter: undefined,
          offsetX: 0,
          offsetY: -10,
        },
        xaxis: {
          labels: {
            show: false,
            minHeight: '20px',
          },
          crosshairs: {
            width: 1
          },
        },
        yaxis: {
          min: 0,
          max: 0,
          seriesName: 'Errors',
          tickAmount: 1,
          labels: {
            formatter: (val) => {
              return Math.round(val);
            },
          },
        },
        labels: [],
        title: {
          text: this.title,
          offsetX: 0,
          style: {
            fontSize: '24px',
            cssClass: 'apexcharts-yaxis-title'
          }
        },
      },
      series: [
        {
          name: 'empty',
          data: [0]
        }
      ],
      displayStart: this.start,
      displayEnd: this.end,
      displayMaxValue: this.maxValue,
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
        'start': this.displayStart,
        'end': this.displayEnd,
        'pageUrl': this.pageUrl,
        'siteId': this.siteId,
      };
      await queryApi(chartsAPI, '', params, (data) => {
        if (data[0] !== undefined) {
          let largest1 = largestNumber([data[0]['data']])[0];
          let largest2 = largestNumber([data[1]['data']])[0];
          let largest = largest1 > largest2 ? largest1 : largest2;
          this.chartOptions = {
            ...this.chartOptions, ...{
              yaxis: {
                min: 0,
                max: largest,
                tickAmount: largest > 10 ? 10 : largest,
                labels: {
                  formatter: (val) => {
                    return Math.round(val);
                  },
                },
              },
              xaxis: {
                categories: data[0]['labels'],
                type: 'category',
                labels: {
                  show: false,
                  minHeight: '20px',
                },
                crosshairs: {
                  width: 1
                },
              },
              labels: data[0]['labels']
            }
          };
          this.series = data;
        }
      });
    },
    onChangeRange(range) {
      this.displayStart = range.start;
      this.displayEnd = range.end;
      this.getSeriesData();
    },
  },
}
</script>
