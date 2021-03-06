// module exports
module.exports = {
  mode: 'jit',
  purge: {
    content: [
      '../src/templates/**/*.{twig,html}',
      '../src/assetbundles/webperf/src/vue/**/*.{vue,html}',
      './node_modules/vuetable-2/src/components/**/*.{vue,html}',
      './node_modules/vue-ctk-date-time-picker/dist/**/*.{vue,html}',
    ],
    layers: [
      'base',
      'components',
      'utilities',
    ],
    mode: 'layers',
    options: {
      whitelist: [
        '../src/assetbundles/webperf/src/css/components/**/*.{css,pcss}',
        './node_modules/vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css',
      ],
    }
  },
  theme: {
  },
  corePlugins: {},
  plugins: [],
};
