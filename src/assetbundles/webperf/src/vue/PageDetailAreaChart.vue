<template>
    <apexcharts width="100%" height="400px" type="area" :options="chartOptions" :series="series"></apexcharts>
</template>

<script>
    import Axios from 'axios';
    import ApexCharts from 'vue-apexcharts';

    const chartDataBaseUrl = '/webperf/charts/pages-area-chart/';

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
            pageUrl: {
                type: String,
                default: '',
            },
            siteId: {
                type: Number,
                default: 0,
            }
        },
        methods: {
            // Load in our chart data asynchronously
            getSeriesData: async function() {
                const chartsAPI = Axios.create(configureApi(chartDataBaseUrl));
                let uri = '';
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
                        options.yaxis.max = Math.round(largestNumber([data[6]['data']])[0] + 1.5);
                        options.labels = data[0]['labels'];
                        this.chartOptions = options;
                        this.series = data;
                    }
                });
            }
        },
        created () {
            this.getSeriesData();
        },
        mounted() {
        },
        data: function() {
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
                        }
                    },
                    colors: [
                        '#FAAD63','#F6993F','#DE751F',
                        '#2779BD', '#3490DC', '#6CB2EB', '#BCDEFA',
                           '#FCD9B6',
                    ],
                    stroke: {
                        curve: 'smooth',
                        width: 3,
                    },
                    fill: {
                        type: 'solid',
                        opacity: 1.0,
                        gradient: {
                            enabled: true
                        }
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
    }
</script>
