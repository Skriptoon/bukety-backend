<template>
  <div>
    <FloatLabel variant="on">
      <Select
        :id="name"
        v-model="model"
        :filter="filter"
        :invalid="Boolean(error)"
        :options="options"
        class="w-full"
        option-label="name"
        option-value="id"
        @focus="$emit('reset-validation')"
      />
      <label :for="name">{{ label }}</label>
    </FloatLabel>
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
import Select from 'primevue/select'
import FloatLabel from 'primevue/floatlabel'

export default {
  name: 'SpDropdown',

  components: {
    Select,
    FloatLabel,
  },

  props: {
    modelValue: Object,
    name: {
      type: String,
      required: true,
    },
    label: String,
    options: {
      type: Array,
      required: true,
    },
    filter: Boolean,
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
