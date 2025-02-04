<template>
  <div>
    <FloatLabel variant="on">
      <InputGroup>
        <inputText
          v-if="!number"
          :id="name"
          v-model="model"
          :disabled="disabled"
          :invalid="Boolean(error)"
          class="w-full"
          @focus="$emit('reset-validation')"
        />
        <InputNumber
          v-else
          :id="name"
          v-model="model"
          :aria-describedby="name"
          :currency="currency"
          :disabled="disabled"
          :invalid="Boolean(error)"
          :max="max"
          :min="min"
          :mode="mode"
          :suffix="suffix"
          class="w-full"
          @focus="$emit('reset-validation')"
        />
        <label :for="name">{{ label }}</label>
        <InputGroupAddon v-if="$slots.postAddon">
          <slot name="postAddon"/>
        </InputGroupAddon>
      </InputGroup>
    </FloatLabel>
    <small
      :id="name"
      class="text-rose-600"
    >
      {{ error }}
    </small>
  </div>
</template>

<script>
import InputText from 'primevue/inputtext'
import InputNumber from 'primevue/inputnumber'
import InputGroup from 'primevue/inputgroup'
import InputGroupAddon from 'primevue/inputgroupaddon'
import FloatLabel from 'primevue/floatlabel'

export default {
  name: 'SpInput',

  components: {
    InputGroupAddon,
    InputGroup,
    InputText,
    InputNumber,
    FloatLabel,
  },

  props: {
    modelValue: [String, Number, null],

    name: {
      type: String,
      required: true,
    },
    label: String,
    disabled: Boolean,
    number: Boolean,
    mode: [String, undefined],
    currency: String,
    min: Number,
    max: Number,
    suffix: String,
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
