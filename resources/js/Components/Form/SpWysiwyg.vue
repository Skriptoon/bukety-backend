<script setup>
import Editor from 'primevue/editor'

defineProps({
  modelValue: Object,
  name: String,
  label: String,
})

defineEmits(['update:modelValue'])
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
  </div>
</template>
