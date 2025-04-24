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
import SpEditor from '@/Components/Form/SpEditor.vue'
import InputGroup from 'primevue/inputgroup'
import InputGroupAddon from 'primevue/inputgroupaddon'

const props = defineProps({
  product: Object,
  categories: Array,
  whomOptions: Array,
  occasionOptions: Array,
  units: Array,
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
  ingredient_values: props.product?.ingredients?.map(ingredient => ingredient.pivot.value) ?? null,
  ingredient_units: props.product?.ingredients?.map(ingredient => ingredient.pivot.unit) ?? null,
  image: null,
  gallery: [],
  is_active: props.product?.is_active ?? false,
  main_category: props.product?.main_category_id ?? null,
  categories: props.product?.categories?.map((category) => category.id) ?? [],
  whom: props.product?.whom ?? null,
  occasion: props.product?.occasion ?? null,
  redirect_url: props.previousUrl,
  uploaded_gallery_images: props.product?.gallery ?? [],
  weight: props.product?.weight ?? null,
  width: props.product?.width ?? null,
  height: props.product?.height ?? null,
  for_flowwow: props.product?.for_flowwow ?? false,
  _method: undefined,
})

const ingredients = ref([])

function sendForm() {
  if (props.product?.id) {
    form._method = 'PUT'
    form.post(route('products.update', props.product.id))
  } else {
    form._method = 'POST'
    form.post(route('products.store'))
  }
}

function imageUp(index) {
  const tmp = form.uploaded_gallery_images[index]

  form.uploaded_gallery_images[index] = form.uploaded_gallery_images[index - 1]
  form.uploaded_gallery_images[index - 1] = tmp
}

function imageDown(index) {
  const tmp = form.uploaded_gallery_images[index]

  form.uploaded_gallery_images[index] = form.uploaded_gallery_images[index + 1]
  form.uploaded_gallery_images[index + 1] = tmp
}

function deleteImage(index) {
  form.uploaded_gallery_images.splice(index, 1)
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

function deleteIngredient(index) {
  form.ingredients.splice(index, 1)
  form.ingredient_values.splice(index, 1)
  form.ingredient_units.splice(index, 1)
}

function addIngredient() {
  form.ingredients.push(null)
  form.ingredient_values.push(null)
  form.ingredient_units.push(null)
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
        v-model="form.main_category"
        :error="form.errors.main_category"
        :options="categories"
        filter
        label="Основная категории"
        name="main_category"
        @reset-validation="form.errors.main_category = null"
      />
    </div>
    <div class="mt-5">
      <SpMultiSelect
        v-model="form.categories"
        :error="form.errors.categories"
        :options="categories"
        filter
        label="Категории"
        name="categories"
        @reset-validation="form.errors.categories = null"
      />
    </div>
    <div class="mt-5">
      <SpEditor
        v-model="form.description"
        :error="form.errors.description"
        label="Описание"
        name="description"
        @reset-validation="form.errors.description = null"
      />
    </div>
    <div class="mt-5">
      <SpTextarea
        v-model="form.vk_description"
        :error="form.errors.vk_description"
        label="Описание для ВК"
        name="vk_description"
        @reset-validation="form.errors.vk_description = null"
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
      <SpInput
        v-model="form.price"
        :error="form.errors.price"
        currency="RUB"
        label="Цена"
        locale="ru-RU"
        mode="currency"
        name="price"
        number
        @reset-validation="form.errors.price = null"
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
        v-model="form.old_price"
        :error="form.errors.old_price"
        currency="RUB"
        label="Старая цена"
        locale="ru-RU"
        mode="currency"
        name="old_price"
        number
        @reset-validation="form.errors.old_price = null"
      />
    </div>
    <div class="mt-5">
      <SpMultiSelect
        v-model="form.whom"
        :error="form.errors.whom"
        :options="whomOptions"
        label="Для кого"
        name="whom"
        @reset-validation="form.errors.whom = null"
      />
    </div>
    <div class="mt-5">
      <SpMultiSelect
        v-model="form.occasion"
        :error="form.errors.occasion"
        :options="occasionOptions"
        label="Повод"
        name="occasion"
        @reset-validation="form.errors.occasion = null"
      />
    </div>
    <div class="mt-5">
      <label>Состав</label>
      <InputGroup
        v-for="(_, index) in form.ingredients"
        class="mt-5"
        :key="index"
      >
        <SpAutocomplete
          v-model="form.ingredients[index]"
          :error="form.errors['ingredients.' + index]"
          :items="ingredients"
          label="Ингридиент"
          :name="'ingredients.' + index"
          @complete="searchIngredients"
          @reset-validation="form.errors['ingredients.' + index] = null"
        />
        <SpInput
          v-model="form.ingredient_values[index]"
          class="w-[120px]"
          label="Количество"
          :name="'ingredient_values.' + index"
          :error="form.errors['ingredient_values.' + index]"
          number
          @reset-validation="form.errors['ingredient_values.' + index] = null"
        />
        <SpDropdown
          v-model="form.ingredient_units[index]"
          class="w-[100px]"
          :name="'ingredient_units.' + index"
          :error="form.errors['ingredient_units.' + index]"
          :options="units"
          @reset-validation="form.errors['ingredient_units.' + index] = null"
        />
        <InputGroupAddon>
          <Button severity="secondary" @click="deleteIngredient(index)">
            <Icon :icon="['fa', 'trash']" />
          </Button>
        </InputGroupAddon>
      </InputGroup>
      <Button
        class="mt-5"
        severity="success"
        @click="addIngredient"
      >
        <Icon :icon="['fa', 'plus']" />
      </Button>
    </div>
    <div class="mt-5">
      <InputGroup>
        <SpInput
          v-model="form.width"
          :error="form.errors.width"
          label="Ширина"
          name="weight"
          number
          @reset-validation="form.errors.width = null"
        />
        <InputGroupAddon>
          см
        </InputGroupAddon>
        <InputGroupAddon>
          x
        </InputGroupAddon>
        <SpInput
          v-model="form.height"
          :error="form.errors.height"
          label="Высота"
          name="height"
          number
          @reset-validation="form.errors.height = null"
        />
        <InputGroupAddon>
          см
        </InputGroupAddon>
      </InputGroup>
    </div>
    <div class="mt-5">
      <SpInput
        v-model="form.weight"
        :error="form.errors.weight"
        label="Вес"
        name="weight"
        number
        @reset-validation="form.errors.weight = null"
      />
    </div>
    <div class="mt-5">
      <SpFileInput
        v-model="form.image"
        :error="form.errors"
        label="Превью"
        name="image"
        @reset-validation="form.clearErrors()"
      />
      <Image
        v-if="product?.image"
        :src="'/storage/' + product.image"
        alt="preview"
        preview
        width="250"
      />
    </div>
    <div class="mt-5">
      <SpFileInput
        v-model="form.gallery"
        :error="form.errors"
        label="Галерея"
        multiple
        name="gallery"
        @reset-validation="form.clearErrors()"
      />
      <div
        v-for="(galleryImage, index) in form.uploaded_gallery_images"
        :key="index"
        class="grid align-items-center mt-2"
      >
        <div class="col-auto">
          <Image
            :src="'/storage/' + galleryImage"
            alt="preview"
            preview
            width="100"
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
              v-if="index + 1 !== form.uploaded_gallery_images.length"
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
        v-model="form.is_active"
        :error="form.errors.is_active"
        label="Активен"
        name="is_active"
        switcher
        @reset-validation="form.errors.is_active = null"
      />
    </div>
    <div class="mt-5">
      <SpCheckbox
        v-model="form.for_flowwow"
        :error="form.errors.for_flowwow"
        label="Добавить на flowwow"
        name="for_flowwow"
        switcher
        @reset-validation="form.errors.for_flowwow = null"
      />
    </div>
    <Button
      class="mt-2"
      severity="success"
      type="submit"
    >
      {{ product?.id ? 'Сохранить' : 'Создать' }}
    </Button>
  </form>
</template>
