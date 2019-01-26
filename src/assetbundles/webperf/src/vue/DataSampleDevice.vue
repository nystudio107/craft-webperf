<template>
    <span class="cursor-default" :class="className" :title="title"> {{ device }}</span>
</template>
<script>
    export default {
        name: 'data-sample-device',
        props: {
            device: String,
            mobile: Boolean,
        },
        computed: {
            className() {
                let className = '';

                if (this.device && this.mobile !== undefined) {
                    className = this.mobile === true ? 'webperf-mobile-icon' : 'webperf-desktop-icon';
                }

                return className;
            },
            title() {
                let title = '';

                if (this.device && this.mobile !== undefined) {
                    title = this.mobile === true ? 'Mobile device' : 'Desktop device';
                }

                return title;
            }
        }
    }
</script>
