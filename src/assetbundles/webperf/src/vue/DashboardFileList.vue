<template>
    <section class="px-3 py-3">
        <div class="text-left text-base font-bold px-2 pt-2">
            Slowest pages
        </div>
        <div v-for="item in series" class="file-list-wrapper p-2">
            <dashboard-file-list-cell :title="item.title"
                                      :url="item.url"
                                      :data="statFormatter(item.data, item.maxValue)"
                                      :cnt="item.cnt"
                                      :width="item.data"
                                      :color="item.barColor"
            >
            </dashboard-file-list-cell>
        </div>
    </section>
</template>

<script>
    import Axios from 'axios';
    import TriBlendColor from '../js/tri-color-blend';
    import DashboardFileListCell from '../vue/DashboardFileListCell.vue';

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
        name: 'dashboard-file-list',
        components: {
            'dashboard-file-list-cell': DashboardFileListCell,
        },
        props: {
            days: {
                type: Number,
                default: 30,
            },
            column: String,
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
                triBlend: new TriBlendColor(this.fastColor, this.averageColor, this.slowColor),
            }
        },
    }
</script>
