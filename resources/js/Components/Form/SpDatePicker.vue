<template>
  <div>
    <div class="p-float-label mb-2">
      <calendar
          v-model="modelValue[name]"
          class="w-full"
          placeholder="Действует до"
          dateFormat="dd.mm.yy"
          selectOtherMonths
          :class="{'p-invalid': modelValue.errors[name]}"
          :showButtonBar="showButtonBar"
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
import Calendar from 'primevue/calendar';

export default {
  name: 'SpDatePicker',

  components: {
    Calendar,
  },

  props: {
    modelValue: Object,
    name: {
      type: String,
      required: true,
    },
    label: String,
    showButtonBar: Boolean,
  },
};
</script>

<style scoped>

</style>
