<script setup>
import FileUpload from 'primevue/fileupload'
import { ref } from 'vue'

const props = defineProps({
  modelValue: Object,
  name: {
    type: String,
    required: true,
  },
  label: String,
  multiple: Boolean,
})

const emit = defineEmits(['update:modelValue'])

const files = ref(null)

function updateFiles() {
  const filesList = [...files.value.files]

  if (!props.multiple && filesList.length > 1) {
    filesList.splice(0, 1)

    files.value.files = [...filesList]
  }

  const form = {...props.modelValue}
  form[props.name] = props.multiple ? files.value.files : files.value.files[0]
  emit('update:modelValue', form)
}
</script>

<template>
  <div>
    <div class="mb-2">
      <div class="mb-2">
        <label>{{ label }}</label>
      </div>
      <FileUpload
          ref="files"
          :name="name"
          :show-upload-button="false"
          :show-cancel-button="false"
          :multiple="multiple"
          @remove="updateFiles"
          @select="updateFiles"
      />
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
