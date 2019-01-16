<template>
    <div>
        <div class="inline-block" style="width: 80%">
            <div class="w-full bg-blue">

            </div>
        </div>
        {{ statFormatter(rowData.pageLoad) }}
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
            }
        },
        methods: {
            statFormatter(val) {
                return Number(val / 1000).toFixed(2) + "s";
            }
        },
        computed: {
        }
    }
</script>
