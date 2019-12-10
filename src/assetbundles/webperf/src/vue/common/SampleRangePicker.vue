<template>
    <div class="readable inline-block">
        <vue-ctk-date-time-picker v-model="dateRange"
                                  :range="true"
                                  :no-header="true"
                                  :only-date="true"
                                  :no-value-to-custom-elem="true"
                                  :custom-shortcuts="customShortcuts"
                                  shortcut="last365Days"
                                  label="Data Sample Date Range"
                                  format="YYYY-MM-DD"
                                  formatted="YYYY-MM-DD"
                                  color="dimgray"
                                  :no-button="true"
                                  :auto-close="true"
                                  @input="onInput()"
        >
            <button type="button"
                    class="btn menubtn text-sm leading-normal text-left"
                    data-icon="date"
                    tabindex="0"
                    role="combobox"
                    aria-haspopup="true"
                    aria-expanded="false"
                    style="min-width: 237px;"
            >
                {{ dateRange.start }} &rarr; {{ dateRange.end }}
            </button>
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
                dateRange: {},
                customShortcuts: [
                    { key: 'today', label: 'Today', value: 'day' },
                    { key: 'yesterday', label: 'Yesterday', value: '-day' },
                    { key: 'thisMonth', label: 'This Month', value: 'month' },
                    { key: 'lastMonth', label: 'Last Month', value: '-month' },
                    { key: 'thisYear', label: 'This Year', value: 'year' },
                    { key: 'lastYear', label: 'Last Year', value: '-year' },
                    { key: 'last365Days', label: 'Last 365 days', value: 365 }
                ],
            }
        },
        methods: {
            onInput() {
                this.$events.fire('change-range', this.dateRange);
            }
        }
    }
</script>
