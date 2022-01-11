<template>
  <div @click="redirectTo(detailPageUrl)">
    <div class="clearafter pb-1">
      <div
        :title="title"
        class="simple-bar-chart-label text-base font-normal truncate-label"
        style="width: 90%;"
      >
        <a
          v-if="title"
          :href="url"
          style="color: rgb(26 13 171);"
          target="_blank"
          @click.stop=""
        >
          {{ title }}
        </a>
        <span
          v-else
          class="text-gray-300"
        ><em>Craft backend route</em></span>
      </div>
      <div class="simple-bar-chart-value">
        <sample-size-warning :sample="cnt" />
      </div>
    </div>
    <div class="clearafter pb-1">
      <cite
        :title="url"
        class="simple-bar-chart-label text-sm font-normal truncate-label"
        style="width: 80%;"
      >
        <a
          :href="url"
          class="hover:no-underline"
          style="color: rgb(0 102 33);"
          target="_blank"
          @click.stop=""
        >
          {{ url }}
        </a>
      </cite>
      <div class="simple-bar-chart-value text-sm font-bold">
        {{ data }}
      </div>
    </div>
    <div class="py-1">
      <div class="file-list-chart-track rounded-full bg-gray-200">
        <div
          :style="{ width: width + '%', backgroundColor: color }"
          class="simple-bar-line h-2 rounded-full"
        />
      </div>
    </div>
  </div>
</template>
<script>
import SampleSizeWarning from '@/vue/common/SampleSizeWarning.vue';

export default {
  name: 'DashboardFileListCell',
  components: {SampleSizeWarning},
  props: {
    title: {
      type: String,
      default: '',
    },
    url: {
      type: String,
      default: '',
    },
    detailPageUrl: {
      type: String,
      default: '',
    },
    data: {
      type: String,
      default: '',
    },
    cnt: {
      type: Number,
      default: 0,
    },
    width: {
      type: Number,
      default: 0,
    },
    color: {
      type: String,
      default: '',
    },
  },
  methods: {
    redirectTo(url) {
      window.location.href = url;
    }
  }
}
</script>
