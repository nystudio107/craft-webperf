<template>
    <apexcharts width="100%" height="300px" type="radialBar" :options="chartOptions" :series="series"></apexcharts>
</template>

<script>
    import Axios from 'axios';
    import ApexCharts from 'vue-apexcharts';

    const chartDataBaseUrl = '/webperf/charts/dashboard-radial-bar/';

    const greenColor = {
        r: 0,
        g: 200,
        b: 0
    };
    const yellowColor = {
        r: 255,
        g: 255,
        b: 0
    };
    const redColor = {
        r: 200,
        g: 0,
        b: 0
    };

    // convert 0..255 R,G,B values to a hexidecimal color string
    const RGBToHex = (r,g,b) => {
        var bin = r << 16 | g << 8 | b;
        return (function(h){
            return new Array(7-h.length).join("0")+h
        })(bin.toString(16).toUpperCase())
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
                        let chartColor = this.colorFromPercentage(val);
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
            colorFromPercentage(val) {
                let startColor = greenColor;
                let endColor = yellowColor;
                if (val >= 50) {
                    startColor = yellowColor;
                    endColor = redColor;
                    val = val - 50;
                }
                const multiplier = (val / 50);
                const r = Math.round(startColor.r + multiplier * (endColor.r - startColor.r));
                const g = Math.round(startColor.g + multiplier * (endColor.g - startColor.g));
                const b = Math.round(startColor.b + multiplier * (endColor.b - startColor.b));
                return '#' + RGBToHex(r,g,b);
            }
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
                                background: "#e7e7e7",
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
                        offsetX: 10,
                        offsetY: 20,
                        style: {
                            fontSize: '18px',
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
            }
        },
    }
</script>
