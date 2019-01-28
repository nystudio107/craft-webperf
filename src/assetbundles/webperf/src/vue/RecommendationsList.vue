<template>
    <div>
        <div class="flex justify-center readable">
            <div class="flex-row" style="max-width: 400px;">
                <div v-for="item in series">
                    <div class="field">
                        <p class="notice text-2xl">
                            <span v-html="item.summary"></span>
                        </p>
                        <div class="heading" style="padding-left: 26px;">
                            <p class="instructions text-xl">
                                <span v-html="item.detail"></span>
                                <a class="go" v-if="learnMoreUrl !== ''" :href="learnMoreUrl" target="_blank" rel="noopener,nofollow">
                                    Learn More
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <sample-pane-footer
                start="start"
                end="end"
                subject="recommendations"
                column="id"
                :site-id="siteId"
                :display-dev-mode-warning="devModeWarning"
        >
        </sample-pane-footer>
    </div>
</template>

<script>
    import Axios from 'axios';
    import SamplePaneFooter from '../vue/SamplePaneFooter.vue';

    const dataBaseUrl = '/webperf/recommendations/list/';

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
            'sample-pane-footer': SamplePaneFooter,
        },
        props: {
            start: String,
            end: String,
            displayDevModeWarning: {
                type: Boolean,
                default: false
            },
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
                const chartsAPI = Axios.create(configureApi(dataBaseUrl));
                let uri = '';
                if (this.siteId !== 0) {
                    uri += '/' + this.siteId;
                }
                let params = {
                    'start': this.displayStart,
                    'end': this.displayEnd,
                    'pageUrl': this.pageUrl
                };
                await queryApi(chartsAPI, uri, params, (data) => {
                    if (data[0] !== undefined) {
                        this.series = data;
                    }
                });
            },
            onChangeRange (range) {
                this.displayStart = range.start;
                this.displayEnd = range.end;
                this.getSeriesData();
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
                series: [],
                displayStart: this.start,
                displayEnd: this.end,
            }
        },
    }
</script>
