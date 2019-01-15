<template>
    <section class="px-3 py-3">
        <div class="text-left text-base font-bold px-2 pt-2">
            Slowest pages
        </div>
        <div v-for="item in series" class="file-list-wrapper p-2">
            <div class="clearafter pb-1">
                <div class="simple-bar-chart-label text-base font-normal truncate-label" style="color: rgb(26, 13, 171); width: 90%;">{{ item.title }}</div>
                <div class="simple-bar-chart-value text-sm font-normal">
                    <div class="field webperf-tooltip">
                            <p class="warning display-block" v-if="item.cnt < 1000">&nbsp;</p>
                        <span class="webperf-tooltiptext webperf-sample-tooltip">
                            Only {{ item.cnt }} data sample<span v-if="item.cnt != 1">s</span>.
                        </span>
                    </div>
                </div>
            </div>
            <div class="clearafter pb-1">
                <cite class="simple-bar-chart-label text-sm font-normal truncate-label" style="color: rgb(0, 102, 33); width: 80%;">{{ item.url }}</cite>
                <div class="simple-bar-chart-value text-sm font-bold">{{ statFormatter(item.data, item.maxValue) }}</div>
            </div>
            <div class="py-1">
                <div class="file-list-chart-track rounded-full bg-grey-lighter">
                    <div class="simple-bar-line h-2 rounded-full" :style="{ width: item.data + '%', backgroundColor: item.barColor }"></div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import Axios from 'axios';
    import TriBlendColor from '../js/tri-color-blend';

    const chartDataBaseUrl = '/webperf/charts/dashboard-slowest-pages/';

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
            days: {
                type: Number,
                default: 30,
            },
            column: String,
            limit: {
                type: Number,
                default: 3,
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
                let uri = this.displayDays + '/' + this.column + '/' + this.limit;
                if (this.siteId !== 0) {
                    uri += '/' + this.siteId;
                }
                await queryApi(chartsAPI, uri, (data) => {
                    // Clone the chartOptions object, and replace the needed values
                    console.log(data);

                    data.forEach((element, index, array) => {
                        let val = element.avg / 1000;
                        let maxValue = this.maxValue;
                        if (val > maxValue) {
                            maxValue = val;
                        }
                        val = (val * 100) / maxValue;
                        array[index].data = val;
                        array[index].maxValue = maxValue;
                        array[index].barColor = this.triBlend.colorFromPercentage(val);
                    });
                    this.series = data;
                });
            },
            onChangeRange (range) {
                this.displayDays = days;
                this.getSeriesData();
            },
            statFormatter(val, maxValue) {
                val = (val * maxValue) / 100;
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
                series: [
                ],
                displayDays: this.days,
                triBlend: new TriBlendColor,
            }
        },
    }
</script>
