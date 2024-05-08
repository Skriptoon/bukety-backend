<script setup>
import { useForm } from '@inertiajs/vue3'
import SpInput from '@/Components/Form/SpInput.vue'
import SpFileInput from '@/Components/Form/SpFileInput.vue'
import Image from 'primevue/image'
import Button from 'primevue/button'
import SpCheckbox from '@/Components/Form/SpCheckbox.vue'

const props = defineProps({
  category: Object,
})

const form = useForm({
  id: props.category?.id ?? null,
  name: props.category?.name ?? null,
  description: props.category?.description ?? null,
  seo_description: props.category?.seo_description ?? null,
  image: null,
  sort: props.category?.sort ?? null,
  is_active: props.category?.is_active ?? false,
  show_in_main: props.category?.show_in_main ?? false,
  is_hidden: props.category?.is_hidden ?? false,
  _method: undefined,
})

function sendForm() {
  if (props.category?.id) {
    form._method = 'PUT'
    form.post(route('categories.update', props.category.id))
  } else {
    form.post(route('categories.store'))
  }
}
function updateImage(val) {
  form.image = val.image
}
</script>

<template>
  <form @submit.prevent="sendForm">
    <div class="mt-2">
      <SpInput
          v-model="form"
          name="name"
          label="Название"
      />
    </div>
    <div class="mt-5">
      <SpInput
          v-model="form"
          name="description"
          label="Описание"
      />
    </div>
    <div class="mt-5">
      <SpInput
          v-model="form"
          name="seo_description"
          label="SEO описание"
      />
    </div>
    <div class="mt-5">
      <SpFileInput
          v-model="form"
          name="image"
          label="Превью"
          @update:modelValue="updateImage"
      />
      <Image
          v-if="category?.image"
          :src="'/storage/' + category.image"
          alt="preview"
          width="250"
          preview
      />
    </div>
    <div class="mt-5">
      <SpInput
          v-model="form"
          name="sort"
          label="Позиция"
      />
    </div>
    <div class="mt-5">
      <SpCheckbox
          v-model="form"
          name="show_in_main"
          label="Отображать на главной"
          switcher
      />
    </div>
    <div class="mt-5">
      <SpCheckbox
          v-model="form"
          name="is_hidden"
          label="Скрытая"
          switcher
      />
    </div>
    <div class="mt-5">
      <SpCheckbox
          v-model="form"
          name="is_active"
          label="Активна"
          switcher
      />
    </div>
    <Button
        severity="success"
        class="mt-2"
        type="submit"
    >
      {{ category?.id ? 'Сохранить' : 'Создать' }}
    </Button>
  </form>
</template>
