<template>
    <div class="request-bar-chart">
        <div>{{ column }}</div>
        <div v-if="nodes.nodes && nodes.nodes.length">
        <request-bar-chart
                v-for="node in nodes"
                :nodes="node.nodes"
                :column="node.column"
                :color="node.color"
                :label="node.label"
                :value="node.value"
                :row-data="rowData"
        >
        </request-bar-chart>
        </div>
    </div>
</template>
<script>
    const requestBarGraphFields = [
        {
            column: 'totalPageLoad',
            color: 'bg-blue-dark',
            label: 'Page Loaded',
        },
        {
            column: 'domInteractive',
            color: 'bg-blue-dark',
            label: 'DOM Interactive',
        },
        {
            column: 'firstContentfulPaint',
            color: 'bg-blue-dark',
            label: 'First Contentful Paint',
        },
        {
            column: 'firstPaint',
            color: 'bg-blue-dark',
            label: 'First Paint',
        },
        {
            column: 'firstByte',
            color: 'bg-blue-dark',
            label: 'First Byte',
        },
        {
            column: 'connect',
            color: 'bg-blue-dark',
            label: 'Connect',
        },
        {
            column: 'dns',
            color: 'bg-blue-dark',
            label: 'DNS Lookup',
        },
        {
            column: 'craftTotalMs',
            color: 'bg-blue-dark',
            label: 'Craft Rendering',
        },
        {
            column: 'craftTwigMs',
            color: 'bg-blue-dark',
            label: 'Twig Rendering',
        },
        {
            column: 'craftDbMs',
            color: 'bg-blue-dark',
            label: 'DB Queries',
        },
    ];

    export default {
        name: 'request-bar-chart',
        props: {
            rowData: Object,
            column: String,
            color: String,
            label: String,
            value: String,
        },
        data: function() {
            let element = requestBarGraphFields[0];
            return {
                nodes: {
                    column: element.column,
                    color: element.color,
                    label: element.label,
                    value: 100,
                },
            }
        },
        created() {
            return;

            requestBarGraphFields.forEach((element) => {
                let node = {
                    column: element.column,
                    color: element.color,
                    label: element.label,
                    value: this.rowData[element.column],
                    nodes: undefined,
                };
                if (this.nodes) {
                    let searchNode = this.nodes;
                    console.log(searchNode);
                    while (searchNode) {
                        if (!searchNode.nodes || (node.value > searchNode.value)) {
                            node.nodes = searchNode.nodes;
                            searchNode.nodes = [node];

                            node.nodes = undefined;
                        }
                        searchNode = searchNode.nodes || undefined;
                        searchNode = undefined;
                    }
                } else {
                    this.nodes = node;
                }
            });
            console.log('exiting requestBarGraphFields.forEach()');
        },
        methods: {
        }
    }
</script>
