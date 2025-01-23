<template>
  <div>
    <div class="mt-8">
      <Checkbox
          v-if="!switcher"
          v-model="model[name]"
          :id="name"
          :class="{'p-invalid': modelValue.errors[name]}"
          :aria-describedby="name"
          :disabled="disabled"
          binary
          @focus="model.errors[name] = null"
      />
      <ToggleSwitch
          v-else
          v-model="model[name]"
          :id="name"
          :class="{'p-invalid': modelValue.errors[name]}"
          :aria-describedby="name"
          :disabled="disabled"
          @focus="model.errors[name] = null"
      />
      <label
          :class="{
            'ml-6': switcher
          }"
          :for="name"
      >
        {{ label }}
      </label>
    </div>
    <small
        v-if="modelValue.errors[name]"
        :id="name"
        class="p-error"
    >
      {{ modelValue.errors[name] }}
    </small>
  </div>
</template>

<script>
import ToggleSwitch from 'primevue/toggleswitch';
import Checkbox from 'primevue/checkbox';

export default {
  name: 'SpCheckbox',

  components: {
    ToggleSwitch,
    Checkbox,
  },

  props: {
    modelValue: Object,

    name: {
      type: String,
      required: true,
    },
    label: String,
    disabled: Boolean,
    switcher: Boolean,
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
