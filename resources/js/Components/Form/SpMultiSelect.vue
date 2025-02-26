<template>
  <div>
    <FloatLabel variant="on">
      <MultiSelect
        :id="name"
        v-model="model"
        :class="{ 'p-invalid': error }"
        :filter="filter"
        :options="options"
        aria-describedby="dd-error"
        class="w-full"
        display="chip"
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
import MultiSelect from 'primevue/multiselect'
import FloatLabel from 'primevue/floatlabel'

export default {
  name: 'SpMultiSelect',

  components: {
    MultiSelect,
    FloatLabel,
  },

  props: {
    modelValue: Object,
    options: Array,
    name: String,
    label: String,
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
