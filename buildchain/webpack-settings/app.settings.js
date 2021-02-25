// app.settings.js

// node modules
require('dotenv').config();
const path = require('path');

// settings
module.exports = {
    alias: {
        '@': path.resolve('../src/assetbundles/webperf/src'),
    },
    copyright: '©2020 nystudio107.com',
    entry: {
        'alerts': '@/js/alerts.js',
        'dashboard': '@/js/dashboard.js',
        'errors-detail': '@/js/errors-detail.js',
        'errors-index': '@/js/errors-index.js',
        'performance-detail': '@/js/performance-detail.js',
        'performance-index': '@/js/performance-index.js',
        'sidebar': '@/js/sidebar.js',
        'webperf': '@/js/webperf.js',
    },
    extensions: ['.ts', '.js', '.vue', '.json'],
    name: 'webperf',
    paths: {
        dist: path.resolve('../src/assetbundles/webperf/dist/'),
    },
    urls: {
        publicPath: () => process.env.PUBLIC_PATH || '',
    },
};
