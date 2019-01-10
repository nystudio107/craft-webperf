<template>
    <div class="simple-bar-chart-wrapper p-5">
        <div class="clearafter py-2">
            <div class="simple-bar-chart-label text-base font-bold">{{ title }}</div>
            <div class="simple-bar-chart-value text-base font-bold">{{ statFormatter(series[0]) }}</div>
        </div>
        <div class="py-2">
            <div class="simple-bar-chart-track rounded-full bg-grey-lighter">
                <div class="h-3 rounded-full" :style="{ width: series[0] + '%', backgroundColor: barColor }"></div>
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
                        this.barColor = this.triBlend.colorFromPercentage(val);
                        this.series = [val];
                    }
                });
            },
            onChangeRange (range) {
                this.displayRange = range;
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
                triBlend: new TriBlendColor,
                barColor: '#000',
                series: [0],
                displayRange: this.range,
                displayMaxValue: this.maxValue,
            }
        },
    }
</script>
