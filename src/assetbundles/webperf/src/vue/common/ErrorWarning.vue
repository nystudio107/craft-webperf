<template>
    <div class="field text-sm font-normal inline-block">
        <p class="warning display-block webperf-error-color" v-if="sample > 0">{{ sample }}</p>
        <p v-else class="display-block text-grey-500">-</p>
    </div>
</template>
<script>
    export default {
        name: 'error-warning',
        props: {
            sample: Number,
        },
    }
</script>
