<script setup>
import { useForm } from '@inertiajs/vue3'
import SpInput from '@/Components/Form/SpInput.vue'
import SpFileInput from '@/Components/Form/SpFileInput.vue'
import Image from 'primevue/image'
import Button from 'primevue/button'
import SpCheckbox from '@/Components/Form/SpCheckbox.vue'
import SpTextarea from '@/Components/Form/SpTextarea.vue'
import SpDropdown from '@/Components/Form/SpDropdown.vue'

const props = defineProps({
  category: Object,
  categories: Array,
})

const form = useForm({
  id: props.category?.id ?? null,
  name: props.category?.name ?? null,
  description: props.category?.description ?? null,
  seo_description: props.category?.seo_description ?? null,
  parent_id: props.category?.parent_id ?? null,
  image: null,
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
</script>

<template>
  <form @submit.prevent="sendForm">
    <div class="mt-2">
      <SpInput
        v-model="form.name"
        :error="form.errors.name"
        label="Название"
        name="name"
        @reset-validation="form.errors.name = null"
      />
    </div>
    <div class="mt-5">
      <SpDropdown
        v-model="form.parent_id"
        :error="form.errors.parent_id"
        :options="categories"
        label="Родительская категория"
        name="parent_id"
        @reset-validation="form.errors.parent_id = null"
      />
    </div>
    <div class="mt-5">
      <SpTextarea
        v-model="form.description"
        :error="form.errors.description"
        label="Описание"
        name="description"
        @reset-validation="form.errors.description = null"
      />
    </div>
    <div class="mt-5">
      <SpTextarea
        v-model="form.seo_description"
        :error="form.errors.seo_description"
        label="SEO описание"
        name="seo_description"
        @reset-validation="form.errors.seo_description = null"
      />
    </div>
    <div class="mt-5">
      <SpFileInput
        v-model="form.image"
        :error="form.errors.image"
        label="Превью"
        name="image"
        @reset-validation="form.errors.image = null"
      />
      <Image
        v-if="category?.image"
        :src="'/storage/' + category.image"
        alt="preview"
        preview
        width="250"
      />
    </div>
    <div class="mt-5">
      <SpCheckbox
        v-model="form.show_in_main"
        label="Отображать на главной"
        name="show_in_main"
        switcher
      />
    </div>
    <div class="mt-5">
      <SpCheckbox
        v-model="form.is_hidden"
        label="Скрытая"
        name="is_hidden"
        switcher
      />
    </div>
    <div class="mt-5">
      <SpCheckbox
        v-model="form.is_active"
        label="Активна"
        name="is_active"
        switcher
      />
    </div>
    <Button
      class="mt-2"
      severity="success"
      type="submit"
    >
      {{ category?.id ? 'Сохранить' : 'Создать' }}
    </Button>
  </form>
</template>
