// app.settings.js

// node modules
require('dotenv').config();

// settings
module.exports = {
    alias: {
    },
    copyright: '©2020 nystudio107.com',
    entry: {
        'alerts': '../src/assetbundles/webperf/src/js/alerts.js',
        'dashboard': '../src/assetbundles/webperf/src/js/dashboard.js',
        'errors-detail': '../src/assetbundles/webperf/src/js/errors-detail.js',
        'errors-index': '../src/assetbundles/webperf/src/js/errors-index.js',
        'performance-detail': '../src/assetbundles/webperf/src/js/performance-detail.js',
        'performance-index': '../src/assetbundles/webperf/src/js/performance-index.js',
        'sidebar': '../src/assetbundles/webperf/src/js/sidebar.js',
        'webperf': '../src/assetbundles/webperf/src/js/webperf.js',
    },
    extensions: ['.ts', '.js', '.vue', '.json'],
    name: 'webperf',
    paths: {
        dist: '../../src/assetbundles/webperf/dist/',
    },
    urls: {
        publicPath: () => process.env.PUBLIC_PATH || '',
    },
};
