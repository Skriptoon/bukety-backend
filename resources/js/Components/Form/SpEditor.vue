<script setup>
import Editor from '@tinymce/tinymce-vue'
import { computed } from 'vue'

const props = defineProps({
  modelValue: String,
  name: String,
  label: String,
  error: String,
})

const emits = defineEmits(['update:modelValue', 'reset-validation'])

const model = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emits('update:modelValue', value)
  },
})
</script>

<template>
  <label for="name">{{ label }}</label>
  <Editor
    :id="name"
    v-model="model"
    :init="{
        height: 500,
        menubar: false,
        plugins: [
          'advlist autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks code fullscreen',
          'insertdatetime media table paste code help wordcount'
        ],
        toolbar:
          'undo redo | formatselect | bold italic backcolor | \
          alignleft aligncenter alignright alignjustify | \
          bullist numlist outdent indent | removeformat | help'
      }"
    api-key="2i85nyo5tx6d5bg7m49fxo96at2okw0zn6i6pflg97j21nre"
  />
  <small
    v-if="error"
    :id="name"
    class="text-rose-600"
  >
    {{ error }}
  </small>
</template>
