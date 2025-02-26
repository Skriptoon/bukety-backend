<script setup>
import {useForm} from '@inertiajs/vue3'
import SpInput from '@/Components/Form/SpInput.vue'
import SpFileInput from '@/Components/Form/SpFileInput.vue'
import SpCheckbox from '@/Components/Form/SpCheckbox.vue'
import Button from 'primevue/button'
import Image from 'primevue/image'
import Icon from '@/Components/Icon.vue'
import {ref} from 'vue'
import SpMultiSelect from '@/Components/Form/SpMultiSelect.vue'
import SpTextarea from '@/Components/Form/SpTextarea.vue'
import SpAutocomplete from '@/Components/Form/SpAutocomplete.vue'
import axios from 'axios'
import SpDropdown from '@/Components/Form/SpDropdown.vue'
import SpEditor from '@/Components/Form/SpEditor.vue';

const props = defineProps({
  product: Object,
  categories: Array,
  whomOptions: Array,
  occasionOptions: Array,
  previousUrl: String,
})

const form = useForm({
  id: props.product?.id ?? null,
  name: props.product?.name ?? null,
  description: props.product?.description ?? null,
  vk_description: props.product?.vk_description ?? null,
  seo_description: props.product?.seo_description ?? null,
  price: props.product?.price ?? null,
  old_price: props.product?.old_price ?? null,
  ingredients: props.product?.ingredients?.map(ingredient => ingredient.name) ?? null,
  image: null,
  gallery: [],
  is_active: props.product?.is_active ?? false,
  main_category: props.product?.main_category_id ?? null,
  categories: props.product?.categories?.map((category) => category.id) ?? [],
  whom: props.product?.whom ?? null,
  occasion: props.product?.occasion ?? null,
  redirect_url: props.previousUrl,
  _method: undefined,
})

const gallery = ref(props.product?.gallery ?? [])
const ingredients = ref([])

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

async function searchIngredients(event) {
  const response = await axios.get(route('products.ingredients'), {
    params: {
      query: event.query,
    },
  })

  ingredients.value = response.data.map(ingredient => ingredient.name)

  if (ingredients.value?.find(ingredient => ingredient === event.query) === undefined) {
    ingredients.value.unshift(event.query)
  }
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
      <SpDropdown
          v-model="form"
          name="main_category"
          label="Основная категории"
          :options="categories"
          filter
      />
    </div>
    <div class="mt-5">
      <SpMultiSelect
          v-model="form"
          name="categories"
          label="Категории"
          :options="categories"
          filter
      />
    </div>
    <div class="mt-5">
      <SpEditor
          v-model="form"
          name="description"
          label="Описание"
      />
    </div>
    <div class="mt-5">
      <SpTextarea
          v-model="form"
          name="vk_description"
          label="Описание для ВК"
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
          name="price"
          label="Цена"
          number
          mode="currency"
          currency="RUB"
          locale="ru-RU"
      >
        <template v-if="form.old_price" #postAddon>
          <div class="white-space-nowrap">
            Скидка: {{ ((1 - form.price / form.old_price) * 100).toFixed() }}%
          </div>
        </template>
      </SpInput>
    </div>
    <div class="mt-5">
      <SpInput
          v-model="form"
          name="old_price"
          label="Старая цена"
          number
          mode="currency"
          currency="RUB"
          locale="ru-RU"
      />
    </div>
    <div class="mt-5">
      <SpMultiSelect
          v-model="form"
          name="whom"
          label="Для кого"
          :options="whomOptions"
      />
    </div>
    <div class="mt-5">
      <SpMultiSelect
          v-model="form"
          name="occasion"
          label="Повод"
          :options="occasionOptions"
      />
    </div>
    <div class="mt-5">
      <SpAutocomplete
          v-model="form"
          name="ingredients"
          label="Состав"
          :items="ingredients"
          @complete="searchIngredients"
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
