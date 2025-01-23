<template>
  <div>
    <FloatLabel class="mt-8">
    <Password
        v-model="modelValue[name]"
        class="w-full"
        :id="name"
        :feedback="feedback"
        :class="{'p-invalid': modelValue.errors[name]}"
        :aria-describedby="name"
        toggleMask
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
import Password from 'primevue/password';
import FloatLabel from 'primevue/floatlabel'

export default {
  name: 'SpPassword',

  components: {
    Password,
    FloatLabel
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
  },
};
</script>
