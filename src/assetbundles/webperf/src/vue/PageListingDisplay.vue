<template>
    <div>
        <div class="text-base font-normal truncate-label"
             style="color: rgb(26, 13, 171); width: 100%;"
             :title="rowData.title"
        >
            {{ rowData.title }}
        </div>
        <cite class="text-sm font-normal truncate-label"
              style="color: rgb(0, 102, 33); width: 100%;"
              :title="rowData.url"
        >
            {{ rowData.url }}
        </cite>
    </div>
</template>

<script>
    export default {
        props: {
            rowData: {
                type: Object,
                required: true
            },
            rowIndex: {
                type: Number
            },
        },
        computed: {
        }
    }
</script>
