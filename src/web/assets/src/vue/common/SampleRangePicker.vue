<template>
  <div class="readable inline-block">
    <vue-ctk-date-time-picker
      v-model="dateRange"
      :auto-close="true"
      :custom-shortcuts="customShortcuts"
      :no-button="true"
      :no-header="true"
      :no-value-to-custom-elem="true"
      :only-date="true"
      :range="true"
      color="dimgray"
      format="YYYY-MM-DD"
      formatted="YYYY-MM-DD"
      label="Data Sample Date Range"
      shortcut="last365Days"
      @input="onInput()"
    >
      <button
        aria-expanded="false"
        aria-haspopup="true"
        class="btn menubtn text-sm leading-normal text-left"
        data-icon="date"
        role="combobox"
        style="min-width: 237px;"
        tabindex="0"
        type="button"
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
  name: 'SampleRangePicker',
  components: {
    'vue-ctk-date-time-picker': VueCtkDateTimePicker,
  },
  data() {
    return {
      dateRange: {},
      customShortcuts: [
        {key: 'today', label: 'Today', value: 'day'},
        {key: 'yesterday', label: 'Yesterday', value: '-day'},
        {key: 'thisMonth', label: 'This Month', value: 'month'},
        {key: 'lastMonth', label: 'Last Month', value: '-month'},
        {key: 'thisYear', label: 'This Year', value: 'year'},
        {key: 'lastYear', label: 'Last Year', value: '-year'},
        {key: 'last365Days', label: 'Last 365 days', value: 365}
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
