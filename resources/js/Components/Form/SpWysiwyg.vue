<script setup>
import Editor from 'primevue/editor'
import { onMounted, ref } from 'vue'

defineProps({
  modelValue: Object,
  name: String,
  label: String,
})

const emit = defineEmits(['update:modelValue'])

const editor = ref()
onMounted(() =>{
})
// editor.value.renderValue('234234234234234')
</script>

<template>
  <div v-if="modelValue[name]">
    <label :for="name">{{ label }}</label>
    <Editor
        v-model="modelValue[name]"
        editor-style="height: 320px"
        class="mt-2"
        :id="name"
    />
  </div>
</template>
