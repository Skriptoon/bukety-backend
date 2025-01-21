<template>
  <div>
    <div class="p-float-label mb-2">
      <DatePicker
          v-model="modelValue[name]"
          class="w-full"
          placeholder="Действует до"
          date-format="dd.mm.yy"
          select-other-months
          :class="{'p-invalid': modelValue.errors[name]}"
          :show-button-bar="showButtonBar"
          :min-date="minDate"
          @focus="modelValue.errors[name] = null"
      />
      <label :for="name">{{ label }}</label>
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
import DatePicker from 'primevue/datepicker';

export default  {
  name: 'SpDatePicker',

  components: {
      DatePicker,
  },

  props: {
    modelValue: Object,
    name: {
      type: String,
      required: true,
    },
    label: String,
    showButtonBar: Boolean,
    minDate: Object,
  },
};
</script>

<style scoped>

</style>
