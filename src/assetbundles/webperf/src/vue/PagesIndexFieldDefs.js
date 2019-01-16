// Field definitions for PagesIndexTable.vue
export default [
    {
        name: '__component:page-listing-display',
        sortField: 'url',
        title: 'Page',
        titleClass: 'center pageListingDisplay',
        dataClass: 'center',
    },
    {
        name: '__component:load-time-bar',
        sortField: 'pageLoad',
        title: 'Load Time',
        titleClass: 'center loadTimeBar',
        dataClass: 'center',
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
