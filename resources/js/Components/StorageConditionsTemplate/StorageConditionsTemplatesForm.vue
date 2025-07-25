<script setup>
import { useForm } from '@inertiajs/vue3'
import SpInput from '@/Components/Form/SpInput.vue'
import Button from 'primevue/button'
import SpEditor from '@/Components/Form/SpEditor.vue'

const props = defineProps({
  storageConditionsTemplate: Object,
})

const form = useForm({
  id: props.storageConditionsTemplate?.id ?? null,
  name: props.storageConditionsTemplate?.name ?? null,
  value: props.storageConditionsTemplate?.value ?? null,
  _method: undefined,
})

function sendForm() {
  if (props.storageConditionsTemplate?.id) {
    form._method = 'PUT'
    form.post(route('storage-conditions-templates.update', props.storageConditionsTemplate.id))
  } else {
    form.post(route('storage-conditions-templates.store'))
  }
}
</script>

<template>
  <form @submit.prevent="sendForm">
    <div class="mt-2">
      <SpInput
        v-model="form.name"
        :error="form.errors.name"
        label="Название"
        name="promo_code"
        @reset-validation="form.errors.name = null"
      />
    </div>
    <div class="mt-5">
      <SpEditor
        v-model="form.value"
        :error="form.errors.value"
        label="Условия хранения"
        name="value"
      />
    </div>
    <Button
      class="mt-2"
      severity="success"
      type="submit"
    >
      {{ storageConditionsTemplate?.id ? 'Сохранить' : 'Создать' }}
    </Button>
  </form>
</template>
