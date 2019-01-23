<template>
    <div class="readable inline-block" style="width: 200px">
        <vue-ctk-date-time-picker v-model="dateRange"
                                  :range="true"
                                  :only-date="true"
                                  :custom-shortcuts="customShortcuts"
                                  label="Data Sample Date Range"
                                  format="YYYY-MM-DD"
                                  formatted="YYYY-MM-DD"
                                  color="dimgray"
                                  :no-button="true"
                                  :auto-close="true"
        >
        </vue-ctk-date-time-picker>
    </div>
</template>
<script>
    import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
    import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';

    export default {
        name: 'sample-range-picker',
        components: {
            'vue-ctk-date-time-picker': VueCtkDateTimePicker,
        },
        watch: {
            dateRange: function (val) {
                this.$events.fire('change-range', val);
            },
        },
        data () {
            return {
                dateRange: null,
                customShortcuts: [
                    { label: 'Today', value: 'day', isSelected: false },
                    { label: 'Yesterday', value: '-day', isSelected: false },
                    { label: 'This Month', value: 'month', isSelected: false },
                    { label: 'Last Month', value: '-month', isSelected: false },
                    { label: 'This Year', value: 'year', isSelected: false },
                    { label: 'Last Year', value: '-year', isSelected: false },
                    { label: 'Last 365 days', value: 365, isSelected: true }
                ],
            }
        },
        methods: {
        }
    }
</script>
