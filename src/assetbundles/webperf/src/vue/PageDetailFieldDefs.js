// Field definitions for PagesIndexTable.vue
export default [
    {
        name: '__slot:page-listing-display',
        sortField: 'url',
        title: 'Page',
        titleClass: 'center pageListingDisplay',
        dataClass: 'center',
    },
    {
        name: '__slot:load-time-bar',
        sortField: 'totalPageLoad',
        title: 'Request Timeline',
        titleClass: 'center loadTimeBar',
        dataClass: 'center',
    },
    {
        name: 'maxTotalPageLoad',
        visible: false,
    },
    {
        name: 'domInteractive',
        visible: false,
    },
    {
        name: 'firstContentfulPaint',
        visible: false,
    },
    {
        name: 'firstPaint',
        visible: false,
    },
    {
        name: 'firstByte',
        visible: false,
    },
    {
        name: 'connect',
        visible: false,
    },
    {
        name: 'dns',
        visible: false,
    },
    {
        name: 'craftDbCnt',
        sortField: 'craftDbCnt',
        title: 'DB Queries',
        titleClass: 'text-right',
        dataClass: 'text-right',
        callback: 'countFormatter'
    },
    {
        name: 'craftTwigCnt',
        sortField: 'craftTwigCnt',
        title: 'Templates',
        titleClass: 'text-right',
        dataClass: 'text-right',
        callback: 'countFormatter'
    },
    {
        name: 'craftOtherCnt',
        sortField: 'craftOtherCnt',
        title: 'Other',
        titleClass: 'text-right',
        dataClass: 'text-right',
        callback: 'countFormatter'
    },
    {
        name: 'craftTotalMemory',
        sortField: 'craftTotalMemory',
        title: 'Memory',
        titleClass: 'text-right',
        dataClass: 'text-right',
        callback: 'memoryFormatter'
    },
];
