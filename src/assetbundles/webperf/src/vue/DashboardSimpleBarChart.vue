<template>
    <div class="simple-bar-chart-wrapper px-5 py-3">
        <div class="clearafter py-2">
            <div class="simple-bar-chart-label text-base font-bold">{{ title }}</div>
            <div class="simple-bar-chart-value text-base font-bold">{{ statFormatter(series[0]) }}</div>
        </div>
        <div class="py-2">
            <div class="simple-bar-chart-track rounded-full bg-grey-lighter">
                <div class="simple-bar-line h-3 rounded-full" :style="{ width: series[0] + '%', backgroundColor: barColor }"></div>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';
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
        },
        props: {
            title: String,
            days: {
                type: Number,
                default: 30,
            },
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
                let uri = this.displayDays + '/' + this.column;
                if (this.siteId !== 0) {
                    uri += '/' + this.siteId;
                }
                let params = {
                    'pageUrl': this.pageUrl
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
                        this.barColor = this.triBlend.colorFromPercentage(val);
                        this.series = [val];
                    }
                });
            },
            onChangeRange (days) {
                this.displayDays = days;
                this.getSeriesData();
            },
            statFormatter(val) {
                val = (val * this.displayMaxValue) / 100;
                return Number(val).toFixed(2) + "s";
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
                barColor: '#000',
                series: [0],
                displayDays: this.days,
                displayMaxValue: this.maxValue,
                triBlend: new TriBlendColor(this.fastColor, this.averageColor, this.slowColor),
            }
        },
    }
</script>
