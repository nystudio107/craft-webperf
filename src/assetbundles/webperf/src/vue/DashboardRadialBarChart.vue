<template>
    <apexcharts width="100%" height="400px" type="radialBar" :options="chartOptions" :series="series"></apexcharts>
</template>

<script>
    import Axios from 'axios';
    import ApexCharts from 'vue-apexcharts';

    const chartDataBaseUrl = '/webperf/charts/dashboard-radial-bar/';

    // Get the largest number from the passed in arrays
    const largestNumber = (mainArray) => {
        return mainArray.map(function(subArray) {
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
            subTitle: String,
            range: String,
            siteId: {
                type: Number,
                default: 0,
            }
        },
        methods: {
            // Load in our chart data asynchronously
            getSeriesData: async function() {
                const chartsAPI = Axios.create(configureApi(chartDataBaseUrl));
                let uri = this.range;
                if (this.siteId !== 0) {
                    uri += '/' + this.siteId;
                }
                await queryApi(chartsAPI, uri, (data) => {
                    // Clone the chartOptions object, and replace the needed values
                    const options = Object.assign({}, this.chartOptions);
                    if (data[0] !== undefined) {
                        options.yaxis.max = Math.round(largestNumber([data[0]['data']])[0] + 1.5);
                        options.labels = data[0]['labels'];
                        this.chartOptions = options;
                        this.series = data;
                    }
                });
            }
        },
        created () {
            //this.getSeriesData();
        },
        mounted() {
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
                    colors: ['#008FFB', '#DCE6EC'],
                    stroke: {
                        curve: 'straight',
                        width: 3,
                    },
                    plotOptions: {
                        radialBar: {
                            startAngle: -135,
                            endAngle: 135,
                            dataLabels: {
                                name: {
                                    fontSize: '16px',
                                    color: undefined,
                                    offsetY: 120
                                },
                                value: {
                                    offsetY: 76,
                                    fontSize: '22px',
                                    color: undefined,
                                    formatter: function (val) {
                                        return val + "%";
                                    }
                                }
                            }
                        }
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'dark',
                            type: 'horizontal',
                            shadeIntensity: 0.5,
                            gradientToColors: ['#ABE5A1'],
                            inverseColors: true,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100]
                        }
                    },
                    xaxis: {
                        crosshairs: {
                            width: 1
                        },
                    },
                    labels: [],
                    yaxis: {
                        min: 0,
                        max: 0,
                    },
                    title: {
                        text: this.title,
                        offsetX: 0,
                        style: {
                            fontSize: '24px',
                            cssClass: 'apexcharts-yaxis-title'
                        }
                    },
                    subtitle: {
                        text: this.subTitle,
                        offsetX: 0,
                        style: {
                            fontSize: '14px',
                            cssClass: 'apexcharts-yaxis-title'
                        }
                    }
                },
                series: [
                    75
                ],
            }
        },
    }
</script>
