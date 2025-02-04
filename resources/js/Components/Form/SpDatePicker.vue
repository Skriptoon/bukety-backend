<template>
  <div>
    <FloatLabel variant="on">
      <DatePicker
        v-model="model"
        :invalid="Boolean(error)"
        :min-date="minDate"
        :show-button-bar="showButtonBar"
        class="w-full"
        date-format="dd.mm.yy"
        placeholder="Действует до"
        select-other-months
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
import DatePicker from 'primevue/datepicker'
import FloatLabel from 'primevue/floatlabel'

export default {
  name: 'SpDatePicker',

  components: {
    DatePicker,
    FloatLabel,
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
