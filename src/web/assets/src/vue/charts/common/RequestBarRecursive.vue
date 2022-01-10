<template>
  <div
    :class="color"
    :style="{width: ((value / parentValue) * 100) + '%'}"
    :title="label + ' ' + statFormatter(value)"
    class="h-5"
  >
    <request-bar-recursive
      v-for="node in nodes"
      :key="node.column"
      :color="node.color"
      :column="node.column"
      :label="node.label"
      :nodes="node.nodes"
      :parent-value="node.parentValue"
      :value="node.value"
    />
  </div>
</template>
<script>
export default {
  name: 'RequestBarRecursive',
  props: {
    column: String,
    color: String,
    label: String,
    value: Number,
    parentValue: Number,
    nodes: Array,
  },
  methods: {
    statFormatter(val) {
      return Number(val / 1000).toFixed(2) + "s";
    },
  },
}
</script>
