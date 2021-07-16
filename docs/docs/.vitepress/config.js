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
            { text: 'SEOmatic Plugin', link: '/' },
            { text: 'SEOmatic Overview', link: '/overview.html' },
            { text: 'Issues & Upgrading', link: '/issues.html' },
            { text: 'SEO Resources', link: '/resources.html' },
            { text: 'SEO Technologies', link: '/technologies.html' },
            { text: 'Configuring SEOmatic', link: '/configuring.html' },
            { text: 'SEOmatic Fields', link: '/fields.html' },
            { text: 'Using SEOmatic', link: '/using.html' },
            { text: 'Advanced Usage', link: '/advanced.html' },
        ],
    },
};
