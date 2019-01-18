<template>
    <div class="h-5"
         :class="color"
         :style="{width: ((value / parentValue) * 100) + '%'}"
         :title="label"
    >
        <request-bar-recursive
                v-for="node in nodes"
                :column="node.column"
                :color="node.color"
                :label="node.label"
                :value="node.value"
                :parentValue="node.parentValue"
                :nodes="node.nodes"
        >
        </request-bar-recursive>
    </div>
</template>
<script>
    export default {
        props: {
            column: String,
            color: String,
            label: String,
            value: Number,
            parentValue: Number,
            nodes: Array,
        },
        name: 'request-bar-recursive'
    }
</script>
