import Vue from 'vue';
import SmallRadialBarChart from '../vue/charts/common/SmallRadialBarChart.vue';
import SmallSimpleBarChart from '../vue/charts/common/SmallSimpleBarChart.vue';
import SmallSamplePaneFooter from '../vue/common/SmallSamplePaneFooter.vue';

// Create our vue instance
const vm = new Vue({
    el: "#cp-nav-content",
    components: {
        'small-radial-bar-chart': SmallRadialBarChart,
        'small-simple-bar-chart': SmallSimpleBarChart,
        'small-sample-pane-footer': SmallSamplePaneFooter,
    },
    data: {
    },
    mounted() {
    },
});
