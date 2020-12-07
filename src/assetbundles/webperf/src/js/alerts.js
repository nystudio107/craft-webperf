import VeeValidate from 'vee-validate';

Vue.use(VeeValidate);
// Create our vue instance
const vm = new Vue({
    el: "#cp-nav-content",
    components: {
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
