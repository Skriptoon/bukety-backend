<template>
  <div>
    <FloatLabel variant="on">
      <Password
        :id="name"
        v-model="model"
        :aria-describedby="name"
        :feedback="feedback"
        :invalid="Boolean(error)"
        class="w-full"
        toggleMask
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
import Password from 'primevue/password'
import FloatLabel from 'primevue/floatlabel'

export default {
  name: 'SpPassword',

  components: {
    Password,
    FloatLabel,
  },

  props: {
    modelValue: Object,

    label: {
      type: String,
      required: true,
    },
    name: {
      type: String,
      required: true,
    },
    feedback: Boolean,
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
