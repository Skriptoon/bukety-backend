<script setup>
import Textarea from 'primevue/textarea'

const props = defineProps({
  modelValue: Object,
  name: String,
  label: String,
})
</script>

<template>
  <div>
    <div class="p-float-label">
      <Textarea
          v-model="modelValue[name]"
          auto-resize
          style="width: 100%"
          :id="name"
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

<style scoped>

</style>