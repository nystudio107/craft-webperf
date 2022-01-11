<template>
  <span
    :title="title"
    class="cursor-default"
  >{{ date }}</span>
</template>
<script>
export default {
  name: 'DataSampleDate',
  props: {
    date: {
      type: String,
      default: '',
    },
    url: {
      type: String,
      default: '',
    },
    query: {
      type: String,
      default: '',
    },
  },
  computed: {
    title() {
      let title = '';

      title += 'Url: ' + this.url;
      if (this.query) {
        title += '\n\n' + 'Query: ' + this.query;
      }

      return title;
    }
  }
}
</script>
