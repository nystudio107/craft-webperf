<template>
    <div class="readable inline-block">
        <vue-ctk-date-time-picker v-model="dateRange"
                                  :range="true"
                                  :no-header="true"
                                  :only-date="true"
                                  :no-value-to-custom-elem="true"
                                  :custom-shortcuts="customShortcuts"
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
            onInput() {
                this.$events.fire('change-range', this.dateRange);
            }
        }
    }
</script>
