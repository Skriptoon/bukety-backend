<script setup>
import { useForm } from '@inertiajs/vue3'
import SpInput from '@/Components/Form/SpInput.vue'
import SpFileInput from '@/Components/Form/SpFileInput.vue'
import SpCheckbox from '@/Components/Form/SpCheckbox.vue'
import Button from 'primevue/button'
import Image from 'primevue/image'
import Icon from '@/Components/Icon.vue'
import { ref } from 'vue'
import SpMultiSelect from '@/Components/Form/SpMultiSelect.vue'
import SpTextarea from '@/Components/Form/SpTextarea.vue'
import SpWysiwyg from '@/Components/Form/SpWysiwyg.vue'

const props = defineProps({
  product: Object,
  categories: Array,
})

const form = useForm({
  id: props.product?.id ?? null,
  name: props.product?.name ?? null,
  description: props.product?.description ?? null,
  preview_description: props.product?.preview_description ?? null,
  seo_description: props.product?.seo_description ?? null,
  vk_url: props.product?.vk_url ?? null,
  price: props.product?.price ?? null,
  image: null,
  gallery: [],
  is_active: props.product?.is_active ?? false,
  categories: props.product?.categories.map((category) => category.id) ?? [],
  _method: undefined,
})

const gallery = ref(props.product?.gallery ?? [])

function sendForm() {
  const tempGallery = [...form.gallery]
  form.gallery = [
    ...form.gallery,
    ...gallery.value,
  ]

  if (props.product?.id) {
    form._method = 'PUT'
    form.post(route('products.update', props.product.id))
  } else {
    form._method = 'POST'
    form.post(route('products.store'))
  }

  form.gallery = [...tempGallery]
}

function updateImage(val) {
  form.image = val.image
}

function updateGallery(val) {
  form.gallery = val.gallery
}

function imageUp(index) {
  const tmp = gallery.value[index]

  gallery.value[index] = gallery.value[index - 1]
  gallery.value[index - 1] = tmp
}

function imageDown(index) {
  const tmp = gallery.value[index]

  gallery.value[index] = gallery.value[index + 1]
  gallery.value[index + 1] = tmp
}

function deleteImage(index) {
  gallery.value.splice(index, 1)
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
      <SpMultiSelect
          v-model="form"
          name="categories"
          label="Категории"
          :options="categories"
      />
    </div>
    <div class="mt-5">
      <SpWysiwyg
          v-model="form"
          name="description"
          label="Описание"
      />
    </div>
    <div class="mt-5">
      <SpInput
          v-model="form"
          name="preview_description"
          label="Краткое описание"
      />
    </div>
    <div class="mt-5">
      <SpTextarea
          v-model="form"
          name="seo_description"
          label="SEO описание"
      />
    </div>
    <div class="mt-5">
      <SpInput
          v-model="form"
          name="vk_url"
          label="Ссылка на товар VK"
      />
    </div>
    <div class="mt-5">
      <SpInput
          v-model="form"
          name="price"
          label="Цена"
          number
          mode="currency"
          currency="RUB"
          locale="ru-RU"
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
          v-if="product?.image"
          :src="'/storage/' + product.image"
          alt="preview"
          width="250"
          preview
      />
    </div>
    <div class="mt-5">
      <SpFileInput
          v-model="form"
          name="gallery"
          label="Галерея"
          multiple
          @update:modelValue="updateGallery"
      />
      <div
          v-for="(galleryImage, index) in gallery"
          :key="index"
          class="grid align-items-center mt-2"
      >
        <div class="col-auto">
          <Image
              :src="'/storage/' + galleryImage"
              alt="preview"
              width="100"
              preview
          />
        </div>
        <div class="col-auto p-4">
          <div class="flex gap-2">
            <Button
                v-if="index !== 0"
                @click="imageUp(index)"
            >
              <Icon icon="caret-up" />
            </Button>
            <Button
                v-if="index + 1 !== gallery.length"
                @click="imageDown(index)"
            >
              <Icon icon="caret-down" />
            </Button>
          </div>
        </div>
        <div class="col-auto">
          <Button
              severity="danger"
              @click="deleteImage(index)"
          >
            <Icon icon="trash" />
          </Button>
        </div>
      </div>
    </div>
    <div class="mt-5">
      <SpCheckbox
          v-model="form"
          name="is_active"
          label="Активен"
          switcher
      />
    </div>
    <Button
        severity="success"
        class="mt-2"
        type="submit"
    >
      {{ product?.id ? 'Сохранить' : 'Создать' }}
    </Button>
  </form>
</template>
