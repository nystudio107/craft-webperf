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
    date: String,
    url: String,
    query: String,
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
