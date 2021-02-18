<template>
  <div :class="['vuetable-pagination-info', css.infoClass]"
    v-html="paginationInfo">
  </div>
</template>

<script>
import PaginationInfoMixin from '@vue/tables/common/VuetablePaginationInfoMixin.vue'

export default {
  mixins: [PaginationInfoMixin],
}
</script>
