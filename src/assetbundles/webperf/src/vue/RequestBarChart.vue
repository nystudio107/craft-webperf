<template>
    <div class="flex flex-no-wrap">
        <div class="flex-shrink" v-if="rowData.type === 'both'" title="Combined Frontend & Craft Beacon">
            <div class="w-2 h-2 bg-blue-dark rounded-full mb-1">
            </div>
            <div class="w-2 h-2 bg-orange-dark rounded-full">
            </div>
        </div>
        <div class="flex-shrink" v-if="rowData.type === 'frontend'" title="Frontend Beacon only">
            <div class="w-2 h-2 bg-blue-dark rounded-full mb-1">
            </div>
            <div class="w-2 h-2 bg-transparent rounded-full">
            </div>
        </div>
        <div class="flex-shrink" v-if="rowData.type === 'craft'" title="Craft Beacon only">
            <div class="w-2 h-2 bg-transparent rounded-full mb-1">
            </div>
            <div class="w-2 h-2 bg-orange-dark rounded-full">
            </div>
        </div>
        <div class="flex-grow">
        <request-bar-recursive :column="root.column"
                               :color="root.color"
                               :label="root.label"
                               :value="root.value"
                               :parentValue="root.parentValue"
                               :nodes="root.nodes"
        >
        </request-bar-recursive>
        </div>
        <div class="flex-shrink">
            {{ statFormatter(root.parentValue) }}
        </div>
    </div>
</template>
<script>
    import RequestBarRecursive from './RequestBarRecursive.vue';

    const requestBarGraphFields = [
        {
            column: 'totalPageLoad',
            color: 'bg-blue-dark',
            label: 'Page Loaded',
        },
        {
            column: 'domInteractive',
            color: 'bg-blue',
            label: 'DOM Interactive',
        },
        {
            column: 'firstContentfulPaint',
            color: 'bg-blue-light',
            label: 'First Contentful Paint',
        },
        {
            column: 'firstPaint',
            color: 'bg-blue-lighter',
            label: 'First Paint',
        },
        {
            column: 'firstByte',
            color: 'bg-orange-dark',
            label: 'First Byte',
        },
        {
            column: 'connect',
            color: 'bg-orange',
            label: 'Connect',
        },
        {
            column: 'dns',
            color: 'bg-orange-light',
            label: 'DNS Lookup',
        },
        {
            column: 'craftTotalMs',
            color: 'bg-red-dark',
            label: 'Craft Rendering',
        },
        {
            column: 'craftTwigMs',
            color: 'bg-red',
            label: 'Twig Rendering',
        },
        {
            column: 'craftDbMs',
            color: 'bg-red-light',
            label: 'DB Queries',
        },
    ];

    export default {
        name: 'request-bar-chart',
        components: {
            'request-bar-recursive': RequestBarRecursive,
        },
        props: {
            rowData: Object,
        },
        data: function() {
            return {
                root: undefined,
            }
        },
        mounted() {
            this.$events.$on('refresh-table-components', eventData => this.onTableRefresh(eventData));
        },
        created() {
            this.calculateNodes();
        },
        methods: {
            onTableRefresh: function (eventData) {
                this.calculateNodes();
            },
            statFormatter(val) {
                return Number(val / 1000).toFixed(2) + "s";
            },
            calculateNodes: function() {
                this.root = undefined;
                requestBarGraphFields.forEach((element) => {
                    let node = {
                        column: element.column,
                        color: element.color,
                        label: element.label,
                        value: parseFloat(this.rowData[element.column]) || null,
                        parentValue: parseFloat(this.rowData['maxTotalPageLoad']) || null,
                        nodes: undefined,
                    };
                    if (node.value) {
                        if (this.root) {
                            let searchNode = this.root;
                            while (searchNode) {
                                if (!searchNode.nodes || (!searchNode.value) || (node.value > searchNode.value)) {
                                    node.nodes = searchNode.nodes;
                                    node.parentValue = searchNode.parentValue;
                                    searchNode.nodes = [node];
                                    searchNode = node.nodes || undefined;
                                } else {
                                    searchNode = searchNode.nodes[0] || undefined;
                                }
                            }
                        } else {
                            this.root = node;
                        }
                    }
                });
            }
        },
    }
</script>
