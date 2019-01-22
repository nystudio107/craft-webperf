<template>
    <div class="readable inline-block" style="width: 200px">
        <vue-ctk-date-time-picker v-model="yourValue"
                                  :range="true"
                                  :only-date="true"
                                  :custom-shortcuts="customShortcuts"
                                  label="Data Sample Date Range"
                                  format="YYYY-MM-DD"
                                  formatted="YYYY-MM-DD"
                                  color="dimgray"
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
        data () {
            return {
                yourValue: null,
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
