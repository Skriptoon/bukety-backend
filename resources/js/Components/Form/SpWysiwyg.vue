<script setup>
import Editor from 'primevue/editor'

defineProps({
  modelValue: Object,
  name: String,
  label: String,
})
</script>

<template>
  <div>
    <label :for="name">{{ label }}</label>
    <Editor
        v-model="modelValue[name]"
        editor-style="height: 320px"
        class="mt-2"
        :id="name"
    />
    <small
        v-if="modelValue.errors[name]"
        :id="name"
        class="p-error"
    >
      {{ modelValue.errors[name] }}
    </small>
  </div>
</template>
