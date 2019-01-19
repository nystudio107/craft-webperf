// Field definitions for PagesIndexTable.vue
export default [
    {
        name: 'dateUpdated',
        sortField: 'dateUpdated',
        title: 'Sample Date',
        titleClass: 'text-left',
        dataClass: 'text-left',
        callback: 'dateFormatter',
        width: '14%',
    },
    {
        name: '__slot:load-time-bar',
        sortField: 'totalPageLoad',
        title: 'Request Timeline',
        titleClass: 'center loadTimeBar',
        dataClass: 'center',
        width: '20%',
    },
    {
        name: 'craftDbCnt',
        sortField: 'craftDbCnt',
        title: 'DB Queries',
        titleClass: 'text-right',
        dataClass: 'text-right',
        callback: 'countFormatter',
        width: '6%',
    },
    {
        name: 'craftTwigCnt',
        sortField: 'craftTwigCnt',
        title: 'Templates',
        titleClass: 'text-right',
        dataClass: 'text-right',
        callback: 'countFormatter',
        width: '6%',
    },
    {
        name: 'craftOtherCnt',
        sortField: 'craftOtherCnt',
        title: 'Other',
        titleClass: 'text-right',
        dataClass: 'text-right',
        callback: 'countFormatter',
        width: '6%',
    },
    {
        name: 'craftTotalMemory',
        sortField: 'craftTotalMemory',
        title: 'Memory',
        titleClass: 'text-right',
        dataClass: 'text-right',
        callback: 'memoryFormatter',
        width: '8%',
    },
    {
        name: 'device',
        sortField: 'device',
        title: 'Device',
        titleClass: 'text-right',
        dataClass: 'text-right',
        width: '10%',
    },
    {
        name: 'os',
        sortField: 'os',
        title: 'OS',
        titleClass: 'text-right',
        dataClass: 'text-right',
        width: '10%',
    },
    {
        name: 'browser',
        sortField: 'browser',
        title: 'Browser',
        titleClass: 'text-right',
        dataClass: 'text-right',
        width: '10%',
    },
    {
        name: 'countryCode',
        sortField: 'countryCode',
        title: 'Country',
        titleClass: 'text-right',
        dataClass: 'text-right',
        width: '6%',
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
];
