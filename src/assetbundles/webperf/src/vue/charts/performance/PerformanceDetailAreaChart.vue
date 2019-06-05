<template>
    <apexcharts width="100%" height="450px" type="area" :options="chartOptions" :series="series"></apexcharts>
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
                    if (data[0] !== undefined) {
                        let largest = largestNumber([data[9]['data']])[0];
                        largest = Math.ceil((largest / 1000)) * 1000;
                        this.chartOptions = {
                            ...this.chartOptions, ...{
                                yaxis: {
                                    min: 0,
                                    max: largest,
                                    labels: {
                                        formatter: (val) => {
                                            return this.statFormatter(val);
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
            onChangeRange (range) {
                this.displayStart = range.start;
                this.displayEnd = range.end;
                this.getSeriesData();
            },
            statFormatter(val) {
                return Number(val / 1000).toFixed(2) + "s";
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
                    dataLabels: {
                        enabled: false,
                    },
                    tooltip: {
                        enabled: true,
                        inverseOrder: true,
                        x: {
                            show: false,
                        },
                    },
                    colors: [
                        '#CC1F1A', '#E3342F', '#EF5753',
                        '#DE751F', '#F6993F', '#FAAD63',
                        '#2779BD', '#3490DC', '#6CB2EB', '#BCDEFA',
                    ],
                    stroke: {
                        curve: 'smooth',
                        width: 3,
                    },
                    fill: {
                        type: 'solid',
                        opacity: 0.9,
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
                        type: 'category',
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
                        seriesName: 'Time',
                        labels: {
                            formatter: (val) => {
                                return this.statFormatter(val);
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
    }
</script>
