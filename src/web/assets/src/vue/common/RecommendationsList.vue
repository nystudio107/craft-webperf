<template>
  <div>
    <div
      v-if="!series.length"
      class="text-3xl text-center py-10"
    >
      &#x1f389; No recommendations found. Nice job!
    </div>
    <div
      v-for="(item, index) in series"
      :key="index"
    >
      <div class="field pb-4">
        <p class="warning text-2xl leading-normal">
          <span v-html="item.summary" />
        </p>
        <div
          class="heading"
          style="padding-left: 26px;"
        >
          <p class="instructions text-xl leading-tight">
            <span v-html="item.detail" />
            <span class="field inline-block m-0">
              <a
                v-if="item.learnMoreUrl !== ''"
                :href="item.learnMoreUrl"
                class="go notice"
                rel="noopener,nofollow"
                target="_blank"
              >Learn More</a>
            </span>
          </p>
        </div>
      </div>
    </div>
    <sample-pane-footer
      :display-dev-mode-warning="devModeWarning"
      :page-url="pageUrl"
      :site-id="siteId"
      column="id"
      end="end"
      start="start"
      subject="recommendations"
    />
  </div>
</template>

<script>
import Axios from 'axios';
import SamplePaneFooter from '@/vue/common/SamplePaneFooter.vue';

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
    'sample-pane-footer': SamplePaneFooter,
  },
  props: {
    start: String,
    end: String,
    devModeWarning: {
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
    },
    apiUrl: {
      type: String,
      default: '',
    },
  },
  data: function () {
    return {
      series: [],
      displayStart: this.start,
      displayEnd: this.end,
    }
  },
  created() {
    this.getSeriesData();
  },
  mounted() {
    this.$events.$on('change-range', eventData => this.onChangeRange(eventData));
  },
  methods: {
    // Load in our chart data asynchronously
    getSeriesData: async function () {
      const chartsAPI = Axios.create(configureApi(this.apiUrl));
      let params = {
        'start': this.displayStart,
        'end': this.displayEnd,
        'pageUrl': this.pageUrl,
        'siteId': this.siteId,
      };
      await queryApi(chartsAPI, '', params, (data) => {
        if (data[0] !== undefined) {
          this.series = data;
        }
      });
    },
    onChangeRange(range) {
      this.displayStart = range.start;
      this.displayEnd = range.end;
      this.getSeriesData();
    },
  },
}
</script>
