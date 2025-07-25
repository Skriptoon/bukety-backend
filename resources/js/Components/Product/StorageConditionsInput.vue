<script setup>
import SpEditor from '@/Components/Form/SpEditor.vue'
import SpDropdown from '@/Components/Form/SpDropdown.vue'
import InputGroup from 'primevue/inputgroup'
import Button from 'primevue/button'
import { computed, ref } from 'vue'

const props = defineProps({
  modelValue: String,
  error: String,
  storageConditionsTemplates: Array,
})

const emit = defineEmits(['reset-validation', 'update:modelValue'])

const model = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value),
})

const storageConditionsTemplateOptions = props.storageConditionsTemplates.map((template) => {
  return {
    name: template.name,
    id: template.id,
  }
})

const storageConditionsTemplate = ref(null)

function selectStorageConditionsTemplate() {
  if (storageConditionsTemplate.value) {
    const template = props.storageConditionsTemplates.find(
      (template) => template.id === storageConditionsTemplate.value)
    console.log(template)
    model.value = template?.value
  }
}
</script>

<template>
  <div class="mt-5">
    Заполнить условия хранения из шаблона
    <InputGroup>
      <SpDropdown
        v-model="storageConditionsTemplate"
        class="w-full"
        name="storageConditionsTemplate"
        :options="storageConditionsTemplateOptions"
      />
      <InputGroupAddon>
        <Button @click="selectStorageConditionsTemplate">
          Выбрать
        </Button>
      </InputGroupAddon>
    </InputGroup>
  </div>
  <div class="mt-5">
    <SpEditor
      v-model="model"
      label="Условия хранения"
      name="storage_conditions"
      :error="error"
      @reset-validation="$emit('reset-validation')"
    />
  </div>
</template>

<style scoped>

</style>