// webpack.prod.js
// production build config

// environment
process.env.NODE_ENV = process.env.NODE_ENV || 'production';

// webpack config file helpers
const { buildWebpackConfigs, legacyWebpackConfigs, modernWebpackConfigs } = require('get-webpack-config');

// production multi-compiler module exports
module.exports = [
    legacyWebpackConfigs(
        'app',
        'production',
        'manifest',
        'babel-loader',
        'image-loader',
        'font-loader',
        'postcss-loader',
        'typescript-loader',
        'vue-loader',
        'banner',
        'compression',
        'bundle-analyzer',
    ),
    buildWebpackConfigs(
        'build',
        'clean',
        'copy',
    ),
];
