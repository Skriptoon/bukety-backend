<template>
  <div>
    <FloatLabel class="mt-8">
      <MultiSelect
          v-model="modelValue[name]"
          :id="name"
          :options="options"
          :class="{ 'p-invalid': modelValue.errors[name] }"
          :filter="filter"
          class="w-full"
          display="chip"
          option-label="name"
          option-value="id"
          placeholder="Не выбрано"
          aria-describedby="dd-error"
      />
      <label :for="name">{{ label }}</label>
    </FloatLabel>
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
import MultiSelect from 'primevue/multiselect';
import FloatLabel from 'primevue/floatlabel'

export default {
  name: 'SpMultiSelect',

  components: {
    MultiSelect,
    FloatLabel
  },

  props: {
    modelValue: Object,
    options: Array,
    name: String,
    label: String,
    filter: Boolean,
  },
};
</script>
