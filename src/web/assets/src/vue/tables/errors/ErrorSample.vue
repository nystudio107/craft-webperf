<template>
  <div>
    <div v-if="parsedErrors">
      <div v-if="type === 'craft'">
        <h4 class="text-red-300 m-0">
          Craft Errors:
        </h4>
        <div
          v-for="(message, index) in parsedErrors"
          :key="index"
        >
          <div class="field text-sm font-normal inline-block pt-2">
            <p
              :class="[message.level === 'error' ? 'webperf-error-color' : '']"
              class="warning display-block"
            >
              {{ uppercaseFirstChar(message.level) }} &rarr; {{ message.message }}
            </p>
            <p class="m-0 text-gray-600">
              From &rarr; {{ message.category }}
            </p>
          </div>
        </div>
      </div>
      <div v-else-if="type === 'boomerang'">
        <h4 class="text-green-300 m-0">
          JavaScript Errors:
        </h4>
        <div
          v-for="(message, index) in parsedErrors"
          :key="index"
        >
          <div class="field text-sm font-normal inline-block pt-2">
            <p class="warning display-block webperf-error-color">
              Error &rarr; {{ message.t }} {{ message.c }} {{ message.m }} {{ message.x }}
            </p>
            <p class="m-0 text-gray-600">
              Stack Trace &rarr;
              <ul class="list-reset">
                <li
                  v-for="(item, lindex) in message.f"
                  :key="lindex"
                  class="text-gray-600 pl-2"
                >
                  {{ item.l }}:{{ item.c }} {{ item.f }} {{ item.w }} {{ item.wo }}
                </li>
              </ul>
            </p>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <span>
        <code>
          {{ pageErrors }}
        </code>
      </span>
    </div>
  </div>
</template>
<script>
export default {
  name: 'ErrorSample',
  props: {
    pageErrors: {
      type: String,
      default: '',
    },
    type: {
      type: String,
      default: '',
    },
  },
  data: function () {
    return {
      parsedErrors: undefined,
    };
  },
  mounted() {
    try {
      this.parsedErrors = JSON.parse(this.pageErrors);
    } catch (e) {
      console.log(e.message);
    }
  },
  methods: {
    uppercaseFirstChar(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }
  },
}
</script>
