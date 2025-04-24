<script setup>
import AutoComplete from 'primevue/autocomplete'
import FloatLabel from 'primevue/floatlabel'
import {computed} from 'vue'

const props = defineProps({
  modelValue: Object,
  name: String,
  label: String,
  items: Array,
  error: String,
  multiple: Boolean,
})

const emit = defineEmits(['complete', 'update:modelValue'])

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
      <AutoComplete
        v-model="model"
        :suggestions="items"
        :multiple="multiple"
        :invalid="Boolean(error)"
        @complete="$emit('complete', $event)"
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
