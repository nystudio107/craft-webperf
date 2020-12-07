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

// Accept HMR as per: https://webpack.js.org/api/hot-module-replacement#accept
if (module.hot) {
    module.hot.accept();
}
