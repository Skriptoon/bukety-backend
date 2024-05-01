<template>
  <div>
    <div class="p-float-label mb-2">
      <input-text
          v-if="!number"
          v-model="model[name]"
          class="w-full"
          :id="name"
          :class="{'p-invalid': modelValue.errors[name]}"
          :aria-describedby="name"
          :disabled="disabled"
          @focus="model.errors[name] = null"
      />
      <InputNumber
          v-else
          v-model="model[name]"
          class="w-full"
          :id="name"
          :class="{'p-invalid': modelValue.errors[name]}"
          :aria-describedby="name"
          :disabled="disabled"
          :mode="mode"
          :currency="currency"
          @focus="model.errors[name] = null"
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
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';

export default {
  name: 'SpInput',

  components: {
    InputText,
    InputNumber,
  },

  props: {
    modelValue: Object,

    name: {
      type: String,
      required: true,
    },
    label: String,
    disabled: Boolean,
    number: Boolean,
    mode: 'decimal' | 'currency' | undefined,
    currency: String,
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
