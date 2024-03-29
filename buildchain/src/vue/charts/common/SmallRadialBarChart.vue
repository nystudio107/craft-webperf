<template>
  <apexcharts
    :options="chartOptions"
    :series="series"
    height="155"
    type="radialBar"
    width="100%"
  />
</template>

<script>
import Axios from 'axios';
import ApexCharts from 'vue-apexcharts';
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
  components: {
    'apexcharts': ApexCharts,
  },
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
      chartOptions: {
        chart: {
          id: 'vuechart-dashboard-radial-bar',
          fontFamily: 'inherit',
          toolbar: {
            show: false,
          },
        },
        states: {
          hover: {
            filter: {
              type: 'none',
              value: 0,
            }
          },
        },
        colors: ['#000000'],
        plotOptions: {
          radialBar: {
            startAngle: -135,
            endAngle: 135,
            hollow: {
              size: '50%',
            },
            track: {
              background: "#dae1e7",
              strokeWidth: '97%',
              margin: 5, // margin is in pixels
              shadow: {
                enabled: true,
                top: 2,
                left: 0,
                color: '#999',
                opacity: 1,
                blur: 2
              }
            },
            dataLabels: {
              name: {
                show: false,
                fontSize: '16px',
                color: '#333',
                offsetY: 100
              },
              value: {
                offsetY: 6,
                fontSize: '18px',
                color: '#333',
                style: {
                  cssClass: 'apexcharts-datalabel-value',
                },
                formatter: (val) => {
                  val = (val * this.displayMaxValue) / 100;
                  return Number(val).toFixed(2) + "s";
                }
              }
            }
          }
        },
        labels: [this.title],
        title: {
          text: this.title,
          offsetY: 10,
          align: 'center',
          style: {
            color: '#606f7b',
            fontSize: '15px',
            cssClass: 'apexcharts-title-text'
          }
        },
        stroke: {
          width: 1,
          lineCap: 'round'
        },
      },
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
          let chartColor = this.triBlend.colorFromPercentage(val);
          this.chartOptions = {
            ...this.chartOptions, ...{
              colors: [chartColor],
              plotOptions: {
                radialBar: {
                  dataLabels: {
                    value: {
                      color: chartColor,
                    }
                  }
                }
              },
            }
          };
          this.series = [val];
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
