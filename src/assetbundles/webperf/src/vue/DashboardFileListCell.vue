<template>
    <div>
        <div class="clearafter pb-1">
            <div class="simple-bar-chart-label text-base font-normal truncate-label"
                 style="color: rgb(26, 13, 171); width: 90%;"
                 :title="title"
            >
                <span v-if="title">{{ title }}</span>
                <span v-else class="text-grey-light"><em>Craft backend route</em></span>
            </div>
            <div class="simple-bar-chart-value text-sm font-normal">
                <div class="field webperf-tooltip">
                    <p class="warning display-block" v-if="cnt < 1000">&nbsp;</p>
                    <span class="webperf-tooltiptext webperf-sample-tooltip">
                    Only {{ cnt }} data sample<span v-if="cnt != 1">s</span>.
                </span>
                </div>
            </div>
        </div>
        <div class="clearafter pb-1">
            <cite class="simple-bar-chart-label text-sm font-normal truncate-label"
                  style="color: rgb(0, 102, 33); width: 80%;"
                  :title="url"
            >
                {{ url }}
            </cite>
            <div class="simple-bar-chart-value text-sm font-bold">{{ data }}</div>
        </div>
        <div class="py-1">
            <div class="file-list-chart-track rounded-full bg-grey-lighter">
                <div class="simple-bar-line h-2 rounded-full" :style="{ width: width + '%', backgroundColor: color }"></div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'dashboard-file-list-cell',
        props: {
            title: String,
            url: String,
            data: String,
            cnt: Number,
            width: Number,
            color: String,
        },
    }
</script>
