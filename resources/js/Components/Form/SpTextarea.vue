<script setup>
import Textarea from 'primevue/textarea'
import FloatLabel from 'primevue/floatlabel'

defineProps({
  modelValue: Object,
  name: String,
  label: String,
})
</script>

<template>
  <div>
    <FloatLabel class="mt-8">
      <Textarea
          v-model="modelValue[name]"
          auto-resize
          style="width: 100%"
          :id="name"
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

<style scoped>

</style>