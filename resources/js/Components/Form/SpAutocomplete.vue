<script setup>
import AutoComplete from 'primevue/autocomplete'
import FloatLabel from 'primevue/floatlabel'

defineProps({
  modelValue: Object,
  name: String,
  label: String,
  items: Array,
})

defineEmits(['complete'])
</script>

<template>
  <div>
    <FloatLabel class="mt-8">
      <AutoComplete
          v-model="modelValue[name]"
          multiple
          :suggestions="items"
          @complete="$emit('complete', $event)"
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
