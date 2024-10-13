<script setup>
import AutoComplete from 'primevue/autocomplete'

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
    <div class="p-float-label">
      <AutoComplete
          v-model="modelValue[name]"
          multiple
          :suggestions="items"
          @complete="$emit('complete', $event)"
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
