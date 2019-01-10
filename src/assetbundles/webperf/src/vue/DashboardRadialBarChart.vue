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
            title: String,
            range: String,
            column: String,
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
                let uri = this.displayRange + '/' + this.column;
                if (this.siteId !== 0) {
                    uri += '/' + this.siteId;
                }
                await queryApi(chartsAPI, uri, (data) => {
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
                        //options.plotOptions.radialBar.dataLabels.value.color = chartColor;
                        this.chartOptions = options;
                        this.series = [val];
                    }
                });
            },
            onChangeRange (range) {
                this.displayRange = range;
                this.getSeriesData();
            },
        },
        created () {
            this.getSeriesData();
        },
        mounted() {
            this.$events.$on('change-range', eventData => this.onChangeRange(eventData));
            // Live refresh the data
            setInterval(() => {
                //this.getSeriesData();
            }, 3000);
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
                        offsetY: 36,
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
                displayRange: this.range,
                displayMaxValue: this.maxValue,
                triBlend: new TriBlendColor,
            }
        },
    }
</script>
