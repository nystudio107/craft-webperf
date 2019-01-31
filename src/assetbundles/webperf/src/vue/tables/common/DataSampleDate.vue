<template>
    <span class="cursor-default" :title="title">{{ date }}</span>
</template>
<script>
    export default {
        name: 'data-sample-date',
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
