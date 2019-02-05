import Vue from 'vue';
import RadialBarChart from '../vue/charts/common/RadialBarChart.vue';
import SimpleBarChart from '../vue/charts/common/SimpleBarChart.vue';
import SamplePaneFooter from '../vue/common/SamplePaneFooter.vue';

// Create our vue instance
const vm = new Vue({
    el: "#cp-nav-content",
    components: {
        'radial-bar-chart': RadialBarChart,
        'simple-bar-chart': SimpleBarChart,
        'sample-pane-footer': SamplePaneFooter,
    },
    data: {
    },
    mounted() {
    },
});
