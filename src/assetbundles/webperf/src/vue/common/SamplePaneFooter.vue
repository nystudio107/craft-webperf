<template>
    <div class="field">
        <div class="heading">
            <p class="instructions">The {{ subject }} data is an <em>average</em> of <strong>{{ formatNumber(samples) }}</strong> data sample<span v-if="samples !== 1">s</span>.</p>
        </div>
        <p v-if="samples < 100" class="warning">Webperf has collected less than <strong>100</strong> data samples. The sample size is not statistically significant, so above averaged results may not be meaningful.</p>
        <p v-if="displayDevModeWarning" class="warning">Craft performance will be slower than normal with <code>devMode</code> enabled due to extensive logging and disabling of some caches. <span class="field inline-block m-0"><a class="notice go" href="https://craftcms.com/guides/what-dev-mode-does" target="_blank">Learn More</a></span></p>
    </div>
</template>

<script>
    import Axios from 'axios';

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
        api.get(uri, {params: params})
            .then((result) => {
                if (callback) {
                    callback(result.data);
                }
            })
            .catch((error) => {
                console.log(error);
            })
    };

    // Our component exports
    export default {
        components: {
        },
        props: {
            start: String,
            end: String,
            column: String,
            displayDevModeWarning: {
                type: Boolean,
                default: false
            },
            pageUrl: {
                type: String,
                default: '',
            },
            subject: {
                type: String,
                default: '',
            },
            siteId: {
                type: Number,
                default: 0,
            },
            apiUrl: {
                type: String,
                default: '',
            },
        },
        methods: {
            // Load in our chart data asynchronously
            getSeriesData: async function() {
                const chartsAPI = Axios.create(configureApi(this.apiUrl));
                let params = {
                    'column': this.column,
                    'start': this.displayStart,
                    'end': this.displayEnd,
                    'pageUrl': this.pageUrl,
                    'siteId': this.siteId,
                };
                await queryApi(chartsAPI, '', params, (data) => {
                    if (data.cnt !== undefined) {
                        this.samples = data.cnt;
                    }
                });
            },
            onChangeRange (range) {
                this.displayStart = range.start;
                this.displayEnd = range.end;
                this.getSeriesData();
            },
            formatNumber(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
        created () {
            this.getSeriesData();
        },
        mounted() {
            this.$events.$on('change-range', eventData => this.onChangeRange(eventData));
        },
        data: function() {
            return {
                samples: 0,
                displayEnd: this.end,
                displayMaxValue: this.maxValue,
            }
        },
    }
</script>
