<template>
    <div class="simple-bar-chart-wrapper px-3 py-1">
        <div class="clearafter py-1">
            <div class="simple-bar-chart-label text-sm font-bold text-gray-600">{{ title }}</div>
            <div class="simple-bar-chart-value text-sm font-bold text-gray-600">{{ statFormatter(series[0]) }}</div>
        </div>
        <div class="py-1">
            <div class="simple-bar-chart-track rounded-full bg-gray-300">
                <div class="simple-bar-line h-1 rounded-full" :style="{ width: series[0] + '%', backgroundColor: barColor }"></div>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';
    import TriBlendColor from '../../../js/tri-color-blend.js';

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
                    'pageUrl': this.pageUrl
                };
                await queryApi(chartsAPI, uri, params, (data) => {
                    if (data.avg !== undefined) {
                        let val = data.avg / 1000;
                        if (val > this.displayMaxValue) {
                            this.displayMaxValue = val;
                        }
                        val = (val * 100) / this.displayMaxValue;
                        this.barColor = this.triBlend.colorFromPercentage(val);
                        this.series = [val];
                    }
                });
            },
            onChangeRange (range) {
                this.displayStart = range.start;
                this.displayEnd = range.end;
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
            if (this.$events !== undefined) {
                this.$events.$on('change-range', eventData => this.onChangeRange(eventData));
            }
        },
        data: function() {
            return {
                barColor: '#000',
                series: [0],
                displayStart: this.start,
                displayEnd: this.end,
                displayMaxValue: this.maxValue,
                triBlend: new TriBlendColor(this.fastColor, this.averageColor, this.slowColor),
            }
        },
    }
</script>
