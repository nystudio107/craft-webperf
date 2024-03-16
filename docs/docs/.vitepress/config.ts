import {defineConfig} from 'vitepress'

export default defineConfig({
  title: 'Webperf Plugin',
  description: 'Documentation for the Webperf plugin',
  base: '/docs/webperf/',
  lang: 'en-US',
  head: [
    ['meta', {content: 'https://github.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://twitter.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://youtube.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://www.facebook.com/newyorkstudio107', property: 'og:see_also',}],
  ],
  themeConfig: {
    socialLinks: [
      {icon: 'github', link: 'https://github.com/nystudio107'},
      {icon: 'twitter', link: 'https://twitter.com/nystudio107'},
    ],
    logo: '/img/plugin-logo.svg',
    editLink: {
      pattern: 'https://github.com/nystudio107/craft-webperf/edit/develop-v4/docs/docs/:path',
      text: 'Edit this page on GitHub'
    },
    algolia: {
      appId: 'T6JC4YE35L',
      apiKey: '071b68301938ade2178101974f60c3ac',
      indexName: 'webperf',
      searchParameters: {
        facetFilters: ["version:v5"],
      },
    },
    lastUpdatedText: 'Last Updated',
    sidebar: [
      {
        text: 'Topics',
        items: [
          {text: 'Webperf Plugin', link: '/'},
          {text: 'Webperf Overview', link: '/overview.html'},
          {text: 'Performance Resources', link: '/resources.html'},
          {text: 'Configuring Webperf', link: '/configuring.html'},
          {text: 'Using Webperf', link: '/using.html'},
        ],
      }
    ],
    nav: [
      {text: 'Home', link: 'https://nystudio107.com/plugins/webperf'},
      {text: 'Store', link: 'https://plugins.craftcms.com/webperf'},
      {text: 'Changelog', link: 'https://nystudio107.com/plugins/webperf/changelog'},
      {text: 'Issues', link: 'https://github.com/nystudio107/craft-webperf/issues'},
      {
        text: 'v5', items: [
          {text: 'v5', link: '/'},
          {text: 'v4', link: 'https://nystudio107.com/docs/webperf/v4/'},
          {text: 'v1', link: 'https://nystudio107.com/docs/webperf/v1/'},
        ],
      },
    ],
  },
});
