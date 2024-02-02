import Vue from 'vue';
import SmallRadialBarChart from '@/vue/charts/common/SmallRadialBarChart.vue';
import SmallSimpleBarChart from '@/vue/charts/common/SmallSimpleBarChart.vue';
import SmallSamplePaneFooter from '@/vue/common/SmallSamplePaneFooter.vue';

// Create our vue instance
new Vue({
    el: "#cp-nav-content",
    components: {
        SmallRadialBarChart,
        SmallSimpleBarChart,
        SmallSamplePaneFooter,
    },
});
