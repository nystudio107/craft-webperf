<template>
    <apexcharts width="100%" height="300px" type="radialBar" :options="chartOptions" :series="series"></apexcharts>
</template>

<script>
    import Axios from 'axios';
    import ApexCharts from 'vue-apexcharts';
    import TriBlendColor from '../js/tri-color-blend';

    const chartDataBaseUrl = '/webperf/charts/dashboard-stats-average/';

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
        let delimiter='?';
        for (const key of Object.keys(params)) {
            uri = uri + delimiter + encodeURIComponent(key) + '=' + encodeURIComponent(params[key]);
            delimiter = '&';
        }
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
            title: String,
            start: String,
            end: String,
            column: String,
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
            maxValue: Number,
            siteId: {
                type: Number,
                default: 0,
            }
        },
        methods: {
            // Load in our chart data asynchronously
            getSeriesData: async function() {
                const chartsAPI = Axios.create(configureApi(chartDataBaseUrl));
                let uri = this.column;
                if (this.siteId !== 0) {
                    uri += '/' + this.siteId;
                }
                let params = {
                    'start': this.displayStart,
                    'end': this.displayEnd,
                    'pageUrl': this.pageUrl,
                };
                await queryApi(chartsAPI, uri, params, (data) => {
                    // Clone the chartOptions object, and replace the needed values
                    const options = Object.assign({}, this.chartOptions);
                    if (data[0] !== undefined) {
                        let val = data[0] / 1000;
                        if (val > this.displayMaxValue) {
                            this.displayMaxValue = val;
                        }
                        val = (val * 100) / this.displayMaxValue;
                        let chartColor = this.triBlend.colorFromPercentage(val);
                        options.colors = [chartColor];
                        options.plotOptions.radialBar.dataLabels.value.color = chartColor;
                        this.chartOptions = options;
                        this.series = [val];
                    }
                });
            },
            onChangeRange (range) {
                this.displayStart = range.start;
                this.displayEnd = range.end;
                this.getSeriesData();
            },
        },
        created () {
            this.getSeriesData();
        },
        mounted() {
            this.$events.$on('change-range', eventData => this.onChangeRange(eventData));
        },
        data: function() {
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
                                size: '65%',
                            },
                            track: {
                                background: "#f1f5f8",
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
                                    offsetY: 10,
                                    fontSize: '40px',
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
                        offsetY: 18,
                        align: 'center',
                        style: {
                            fontSize: '16px',
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
    }
</script>
