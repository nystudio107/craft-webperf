// Field definitions for PagesIndexTable.vue
export default [
    {
        name: '__slot:error-date',
        sortField: 'dateCreated',
        title: 'Error Date',
        titleClass: 'text-left',
        dataClass: 'text-left',
        width: '15%',
    },
    {
        name: 'pageErrors',
        sortField: 'pageErrors',
        title: 'Errors',
        titleClass: 'text-left',
        dataClass: 'text-left',
        width: '42%',
    },

    {
        name: '__slot:sample-device',
        sortField: 'device',
        title: 'Device',
        titleClass: 'text-left',
        dataClass: 'text-left',
        width: '10%',
    },
    {
        name: 'os',
        sortField: 'os',
        title: 'OS',
        titleClass: 'text-left',
        dataClass: 'text-left',
        width: '10%',
    },
    {
        name: 'browser',
        sortField: 'browser',
        title: 'Browser',
        titleClass: 'text-left',
        dataClass: 'text-left',
        width: '10%',
    },
    {
        name: 'countryCode',
        sortField: 'countryCode',
        title: 'Country',
        titleClass: 'text-left',
        dataClass: 'text-left',
        width: '10%',
    },
    {
        name: 'deleteLink',
        sortField: 'deleteLink',
        title: '',
        titleClass: 'text-center',
        dataClass: 'text-center',
        callback: 'deleteFormatter',
        width: '3%',
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
        name: 'mobile',
        visible: false,
    },
];
