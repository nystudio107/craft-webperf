<template>
    <div class="flex flex-no-wrap">
        <div class="flex-shrink" v-if="rowData.type === 'both'" title="Combined Frontend & Craft Beacon">
            <div class="w-2 h-2 bg-blue-700 rounded-full mb-1">
            </div>
            <div class="w-2 h-2 bg-orange-700 rounded-full">
            </div>
        </div>
        <div class="flex-shrink" v-if="rowData.type === 'frontend'" title="Frontend Beacon only">
            <div class="w-2 h-2 bg-blue-700 rounded-full mb-1">
            </div>
            <div class="w-2 h-2 bg-transparent rounded-full">
            </div>
        </div>
        <div class="flex-shrink" v-if="rowData.type === 'craft'" title="Craft Beacon only">
            <div class="w-2 h-2 bg-transparent rounded-full mb-1">
            </div>
            <div class="w-2 h-2 bg-orange-700 rounded-full">
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
            {{ statFormatter(root.value) }}
        </div>
    </div>
</template>
<script>
    import RequestBarRecursive from '@/vue/charts/common/RequestBarRecursive.vue';

    const requestBarGraphFields = [
        {
            column: 'pageLoad',
            color: 'bg-blue-200',
            label: 'Page Loaded',
        },
        {
            column: 'domInteractive',
            color: 'bg-blue-400',
            label: 'DOM Interactive',
        },
        {
            column: 'firstContentfulPaint',
            color: 'bg-blue-500',
            label: 'First Contentful Paint',
        },
        {
            column: 'firstPaint',
            color: 'bg-blue-700',
            label: 'First Paint',
        },
        {
            column: 'firstByte',
            color: 'bg-orange-400',
            label: 'First Byte',
        },
        {
            column: 'connect',
            color: 'bg-orange-500',
            label: 'Connect',
        },
        {
            column: 'dns',
            color: 'bg-orange-700',
            label: 'DNS Lookup',
        },
        {
            column: 'craftTotalMs',
            color: 'bg-red-400',
            label: 'Craft Rendering',
        },
        {
            column: 'craftTwigMs',
            color: 'bg-red-500',
            label: 'Twig Rendering',
        },
        {
            column: 'craftDbMs',
            color: 'bg-red-700',
            label: 'Database Queries',
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
            if (this.$events !== undefined) {
                this.$events.$on('refresh-table-components', eventData => this.onTableRefresh(eventData));
            }
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
                                    node.parentValue = searchNode.parentValue || searchNode.value;
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
