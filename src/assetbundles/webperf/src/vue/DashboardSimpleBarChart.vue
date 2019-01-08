<template>
    <div class="simple-bar-chart-wrapper p-5">
        <div class="clearafter py-2">
            <div class="simple-bar-chart-label text-base font-bold">{{ title }}</div>
            <div class="simple-bar-chart-value text-base font-bold">{{ statFormatter(series[0]) }}</div>
        </div>
        <div class="py-2">
            <div class="simple-bar-chart-track rounded-full bg-grey-light">
                <div class="h-3 rounded-full" :style="{ width: series[0] + '%', backgroundColor: barColor }"></div>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';

    const chartDataBaseUrl = '/webperf/charts/dashboard-stats-average/';

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
                        this.barColor = this.colorFromPercentage(val);
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
                displayRange: this.range,
                displayMaxValue: this.maxValue,
            }
        },
    }
</script>
