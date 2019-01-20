<template>
    <div>
        <div class="relative single-line-truncate-wrapper">
            <div class="text-base font-normal truncate-label"
                 style="color: rgb(26, 13, 171); width: 100%; height: 20px;"
                 :title="title"
            >
                <span v-if="title">{{ title }}</span>
                <span v-else class="text-grey-light"><em>Craft backend route</em></span>

            </div>
        </div>
        <div class="relative single-line-truncate-wrapper">
            <cite class="text-sm font-normal truncate-label single-line-truncate"
                  style="color: rgb(0, 102, 33); width: 100%; "
                  :title="url"
            >
                {{ url }}
            </cite>
        </div>
        <div class="py-2">
            <div class="simple-bar-chart-track rounded-full bg-grey-lighter">
                <div class="simple-bar-line h-2 rounded-full" :style="{ width: width + '%', backgroundColor: color }"></div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'page-result-cell',
        props: {
            title: String,
            url: String,
            width: Number,
            color: String,
        },
    }
</script>
