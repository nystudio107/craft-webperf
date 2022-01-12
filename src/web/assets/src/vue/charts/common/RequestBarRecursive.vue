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
    column: {
      type: String,
      default: '',
    },
    color: {
      type: String,
      default: '',
    },
    label: {
      type: String,
      default: '',
    },
    value: {
      type: Number,
      default: 0,
    },
    parentValue: {
      type: Number,
      default: 0,
    },
    nodes: {
      type: Array,
      default: () => ([]),
    },
  },
  methods: {
    statFormatter(val) {
      return Number(val / 1000).toFixed(2) + "s";
    },
  },
}
</script>
