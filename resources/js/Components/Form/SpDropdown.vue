<template>
  <div>
    <FloatLabel class="mt-8">
      <Select
          v-model="modelValue[name]"
          class="w-full"
          :options="options"
          :id="name"
          option-label="name"
          option-value="id"
          :class="{'p-invalid': modelValue.errors[name]}"
          :filter="filter"
          @focus="modelValue.errors[name] = null"
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
import Select from 'primevue/select';
import FloatLabel from 'primevue/floatlabel'


export default {
  name: 'SpDropdown',

  components: {
    Select,
    FloatLabel
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

  },
};
</script>

<style scoped>

</style>
