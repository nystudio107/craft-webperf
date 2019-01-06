<template>
    <apexcharts width="100%" height="200px" type="radialBar" :options="chartOptions" :series="series"></apexcharts>
</template>

<script>
    import Axios from 'axios';
    import ApexCharts from 'vue-apexcharts';

    const chartDataBaseUrl = '/webperf/charts/dashboard-radial-bar/';

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
                let uri = this.range + '/' + this.column;
                if (this.siteId !== 0) {
                    uri += '/' + this.siteId;
                }
                await queryApi(chartsAPI, uri, (data) => {
                    // Clone the chartOptions object, and replace the needed values
                    const options = Object.assign({}, this.chartOptions);
                    if (data[0] !== undefined) {
                        let val = data[0] / 1000;
                        options.colors = ['#FF0000'];
                        if (val <= (this.maxValue * .33)) {
                            options.colors = ['#008000'];
                        }
                        if (val <= (this.maxValue * .66)) {
                            options.colors = ['#FFFF00'];
                        }
                        val = (val * 100) / this.maxValue;
                        this.chartOptions = options;
                        this.series = [val];
                    }
                });
            }
        },
        created () {
            this.getSeriesData();
        },
        mounted() {
            // Live refresh the data
            setInterval(() => {
                this.getSeriesData();
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
                                showOn: 'always',
                                name: {
                                    fontSize: '16px',
                                    color: '#333',
                                    offsetY: 80
                                },
                                value: {
                                    offsetY: 40,
                                    fontSize: '22px',
                                    color: undefined,
                                    formatter: (val) => {
                                        val = (val * this.maxValue) / 100;
                                        return Number(val).toFixed(2) + "s";
                                    }
                                }
                            }
                        }
                    },
                    labels: [this.title],
                },
                series: [0],
                stroke: {
                    lineCap: 'round'
                },
            }
        },
    }
</script>
