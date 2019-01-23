// webpack.settings.js - webpack settings config

// node modules
require('dotenv').config();

// Webpack settings exports
// noinspection WebpackConfigHighlighting
module.exports = {
    name: "Webperf",
    copyright: "nystudio107",
    paths: {
        src: {
            base: "./src/assetbundles/webperf/src/",
            css: "./src/assetbundles/webperf/src/css/",
            js: "./src/assetbundles/webperf/src/js/"
        },
        dist: {
            base: "./src/assetbundles/webperf/dist/",
            clean: [
                "./img",
                "./css",
                "./js"
            ]
        },
        templates: "./src/templates/"
    },
    urls: {
        publicPath: () => process.env.PUBLIC_PATH || "",
    },
    vars: {
        cssName: "styles"
    },
    entries: {
        "dashboard": "dashboard.js",
        "page-detail": "page-detail.js",
        "pages-index": "pages-index.js",
        "webperf": "webperf.js",
//        "widget": "widget.js"
    },
    copyWebpackConfig: [
    ],
    devServerConfig: {
        public: () => process.env.DEVSERVER_PUBLIC || "http://localhost:8080",
        host: () => process.env.DEVSERVER_HOST || "localhost",
        poll: () => process.env.DEVSERVER_POLL || false,
        port: () => process.env.DEVSERVER_PORT || 8080,
        https: () => process.env.DEVSERVER_HTTPS || false,
    },
    manifestConfig: {
        basePath: ""
    },
    purgeCssConfig: {
        paths: [
            "./src/templates/**/*.{twig,html}",
            "./node_modules/vuetable-2/src/components/**/*.{vue,html}",
            "./src/assetbundles/webperf/src/vue/**/*.{vue,html}"
        ],
        whitelist: [
            "./src/assetbundles/webperf/src/css/components/**/*.{css,pcss}",
            "./node_modules/vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css",
        ],
        whitelistPatterns: [],
        extensions: [
            "html",
            "js",
            "twig",
            "vue"
        ]
    },
    saveRemoteFileConfig: [
    ],
    createSymlinkConfig: [
    ],
};
