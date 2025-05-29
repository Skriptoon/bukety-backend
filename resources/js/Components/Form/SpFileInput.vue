<script setup>
import FileUpload from 'primevue/fileupload'
import { ref } from 'vue'
import { Cropper } from 'vue-advanced-cropper'
import { Button, Dialog } from 'primevue'
import Icon from '@/Components/Icon.vue'

const props = defineProps({
  modelValue: [Array, Object],
  name: {
    type: String,
    required: true,
  },
  label: String,
  multiple: Boolean,
  error: [String, Object],
})

const emit = defineEmits(['update:modelValue', 'reset-validation'])

const files = ref(null)
const modalVisible = ref(false)
const croppedImages = ref([])
const croppedImagesData = ref([])
const croppingImage = ref(null)
const croppingImageIndex = ref(null)
const showCroppedImage = ref(false)

function updateFiles() {
  const filesList = [...files.value.files]

  if (!props.multiple && filesList.length > 1) {
    filesList.splice(0, 1)

    files.value.files = [...filesList]
  }

  filesList.forEach((file, index) => {
    filesList[index] = {
      file: file,
      ...croppedImagesData.value[index],
    }
  })

  emit('update:modelValue', props.multiple ? filesList : filesList[0])
}

function onChange({canvas, coordinates}) {
  croppedImages.value[croppingImageIndex.value] = canvas.toDataURL()
  croppedImagesData.value[croppingImageIndex.value] = coordinates
}

function openCropper(index, file) {
  croppingImage.value = file.objectURL
  croppingImageIndex.value = index
  modalVisible.value = true
  showCroppedImage.value = false
}

function saveCrop() {
  let filesList = [...files.value.files]

  filesList.forEach((file, index) => {
    filesList[index] = {
      file: file,
      ...croppedImagesData.value[index],
    }
  })

  emit('update:modelValue', props.multiple ? filesList : filesList[0])

  modalVisible.value = false
  showCroppedImage.value = true
}

function cancelCrop() {
  croppedImages.value[croppingImageIndex.value] = null

  modalVisible.value = false
}

function defaultSize({imageSize, visibleArea}) {
  return {
    width: (visibleArea || imageSize).width,
  }
}

function onRemoveTemplatingFile(file, removeFileCallback, index) {
  removeFileCallback(index)
  croppedImages.value[index] = null
  croppedImagesData.value[index] = null
  emit('reset-validation')
}

function getError(index) {
  const errorName = props.multiple ? `${props.name}.${index}.file` :  `${props.name}.file`

  return props.error?.[errorName]
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
      >
        <template #content="{ files, uploadedFiles, removeFileCallback, messages }">
          <div class="flex flex-col gap-8 pt-4">
            <Message
                v-for="message of messages"
                :key="message"
                :class="{ 'mb-8': !files.length && !uploadedFiles.length}"
                severity="error"
            >
              {{ message }}
            </Message>

            <div v-if="files.length > 0">
              <div class="flex flex-wrap gap-4">
                <div
                    v-for="(file, index) of files"
                    :key="file.name + file.type + file.size"
                    class="p-8 rounded-border flex flex-col border border-surface items-center gap-4"
                >
                  <div>
                    <img
                        class="cursor-pointer"
                        role="presentation"
                        :alt="file.name"
                        :src="showCroppedImage ? croppedImages[index] : file.objectURL"
                        width="100"
                        height="50"
                        @click="openCropper(index, file)"
                    />
                  </div>
                  <span class="font-semibold text-ellipsis max-w-60 whitespace-nowrap overflow-hidden">{{
                      file.name
                    }}</span>
                  <small
                      v-if="getError(index)"
                      :id="name"
                      class="text-rose-600"
                  >
                    {{ getError(index) }}
                  </small>
                  <Button
                      @click="onRemoveTemplatingFile(file, removeFileCallback, index)"
                      outlined
                      rounded
                      severity="danger"
                  >
                    <Icon :icon="['fas', 'xmark']" />
                  </Button>
                </div>
              </div>
            </div>
          </div>
        </template>
      </FileUpload>
    </div>
    <Dialog v-model:visible="modalVisible" :style="{ width: '80%' }" modal>
      <Cropper
          class="cropper"
          :src="croppingImage"
          :stencil-props="{
            aspectRatio: 1
          }"
          :default-size="defaultSize"
          min-hieght="1200"
          min-width="1200"
          @change="onChange"
      />
      <template #footer>
        <Button label="Отмена" text severity="danger" @click="cancelCrop" />
        <Button label="Сохранить" severity="success" autofocus @click="saveCrop" />
      </template>
    </Dialog>
  </div>
</template>

<style>
@import 'vue-advanced-cropper/dist/style.css';

.cropper {
  height: 70vh;
  width: 100%;
  background: #DDD;
}
</style>