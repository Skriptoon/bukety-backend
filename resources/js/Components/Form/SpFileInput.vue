<script setup>
import FileUpload from 'primevue/fileupload'
import { ref } from 'vue'

const props = defineProps({
  modelValue: [Array , Object],
  name: {
    type: String,
    required: true,
  },
  label: String,
  multiple: Boolean,
  error: String,
})

const emit = defineEmits(['update:modelValue', 'reset-validation'])

const files = ref(null)

function updateFiles() {
  const filesList = [...files.value.files]

  if (!props.multiple && filesList.length > 1) {
    filesList.splice(0, 1)

    files.value.files = [...filesList]
  }

  emit('update:modelValue', props.multiple ? files.value.files : files.value.files[0])
  emit('reset-validation')
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
        :multiple="multiple"
        :name="name"
        :show-cancel-button="false"
        :show-upload-button="false"
        @remove="updateFiles"
        @select="updateFiles"
      />
    </div>
    <small
      v-if="error"
      :id="name"
      class="text-rose-600"
    >
      {{ error }}
    </small>
  </div>
</template>
