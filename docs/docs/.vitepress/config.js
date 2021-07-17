module.exports = {
    title: 'Webperf Plugin Documentation',
    description: 'Documentation for the Webperf plugin',
    base: '/docs/webperf/',
    lang: 'en-US',
    head: [
        ['meta', { content: 'https://github.com/nystudio107', property: 'og:see_also', }],
        ['meta', { content: 'https://www.youtube.com/channel/UCOZTZHQdC-unTERO7LRS6FA', property: 'og:see_also', }],
        ['meta', { content: 'https://www.facebook.com/newyorkstudio107', property: 'og:see_also', }],
    ],
    themeConfig: {
        repo: 'nystudio107/craft-webperf',
        docsDir: 'docs/docs',
        docsBranch: 'v1',
        algolia: {
            apiKey: '',
            indexName: 'webperf'
        },
        editLinks: true,
        editLinkText: 'Edit this page on GitHub',
        lastUpdated: 'Last Updated',
        sidebar: [
            { text: 'Webperf Plugin', link: '/' },
            { text: 'Webperf Overview', link: '/overview.html' },
            { text: 'Performance Resources', link: '/resources.html' },
            { text: 'Configuring Webpef', link: '/configuring.html' },
            { text: 'Using Webpef', link: '/using.html' },
        ],
    },
};
