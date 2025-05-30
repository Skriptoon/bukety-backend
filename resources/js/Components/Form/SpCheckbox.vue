<template>
  <div>
    <div class="mt-8 flex items-center">
      <Checkbox
        v-if="!switcher"
        :id="name"
        v-model="model"
        :aria-describedby="name"
        :disabled="disabled"
        :invalid="Boolean(error)"
        binary
        @focus="$emit('reset-validation')"
      />
      <ToggleSwitch
        v-else
        :id="name"
        v-model="model"
        :aria-describedby="name"
        :disabled="disabled"
        :invalid="Boolean(error)"
        @focus="$emit('reset-validation')"
      />
      <label
        :class="{
            'ml-4': switcher
          }"
        :for="name"
      >
        {{ label }}
      </label>
    </div>
    <small
      v-if="error"
      :id="name"
      class="text-rose-600"
    >
      {{ error }}
    </small>
  </div>
</template>

<script>
import ToggleSwitch from 'primevue/toggleswitch'
import Checkbox from 'primevue/checkbox'

export default {
  name: 'SpCheckbox',

  components: {
    ToggleSwitch,
    Checkbox,
  },

  props: {
    modelValue: Boolean,

    name: {
      type: String,
      required: true,
    },
    label: String,
    disabled: Boolean,
    switcher: Boolean,
    error: String,
  },

  computed: {
    model: {
      get() {
        return this.modelValue
      },
      set(value) {
        this.$emit('update:modelValue', value)
      },
    },
  },
}
</script>
