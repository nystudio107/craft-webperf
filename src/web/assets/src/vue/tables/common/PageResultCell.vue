<template>
  <div>
    <div class="relative single-line-truncate-wrapper">
      <div
        :title="title"
        class="text-base font-normal truncate-label"
        style="width: 100%; height: 20px;"
      >
        <a
          v-if="title"
          :href="url"
          style="color: rgb(26, 13, 171);"
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
    </div>
    <div class="relative single-line-truncate-wrapper">
      <cite
        :title="url"
        class="text-sm font-normal truncate-label single-line-truncate"
        style="width: 100%; "
      >
        <a
          :href="url"
          class="hover:no-underline"
          style="color: rgb(0, 102, 33);"
          target="_blank"
          @click.stop=""
        >
          {{ url }}
        </a>
      </cite>
    </div>
    <div
      v-if="width"
      class="py-2"
    >
      <div class="simple-bar-chart-track rounded-full bg-gray-200">
        <div
          :style="{ width: width + '%', backgroundColor: color }"
          class="simple-bar-line h-2 rounded-full"
        />
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'PageResultCell',
  props: {
    title: String,
    url: String,
    width: Number,
    color: String,
  },
}
</script>
