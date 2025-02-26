<script setup>
import Textarea from 'primevue/textarea'
import FloatLabel from 'primevue/floatlabel'
import { computed } from 'vue'

const props = defineProps({
  modelValue: String,
  name: String,
  label: String,
  error: String,
})

const emit = defineEmits(['complete', 'update:modelValue', 'reset-validation'])

const model = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emit('update:modelValue', value)
  },
})
</script>

<template>
  <div>
    <FloatLabel variant="on">
      <Textarea
        :id="name"
        v-model="model"
        :invalid="Boolean(error)"
        auto-resize
        style="width: 100%"
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
