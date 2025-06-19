<script setup>
import { useForm } from '@inertiajs/vue3'
import SpInput from '@/Components/Form/SpInput.vue'
import SpFileInput from '@/Components/Form/SpFileInput.vue'
import Image from 'primevue/image'
import Button from 'primevue/button'
import SpCheckbox from '@/Components/Form/SpCheckbox.vue'
import SpDropdown from '@/Components/Form/SpDropdown.vue'

const props = defineProps({
  additionalProduct: Object,
  additionalProductTypes: Array,
})

const form = useForm({
  name: props.additionalProduct?.name ?? null,
  type: props.additionalProduct?.type ?? null,
  image: null,
  price: props.additionalProduct?.price ?? null,
  is_active: props.additionalProduct?.is_active ?? false,
  _method: undefined,
})

function sendForm() {
  if (props.additionalProduct?.id) {
    form._method = 'PUT'
    form.post(route('additional-products.update', props.additionalProduct.id))
  } else {
    form._method = 'POST'
    form.post(route('additional-products.store'))
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
        v-model="form.type"
        :options="additionalProductTypes"
        :error="form.errors.type"
        label="Тип товара"
        name="product_type"
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
        v-if="additionalProduct?.image"
        :src="'/storage/' + additionalProduct.image"
        alt="preview"
        preview
        width="250"
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
      {{ additionalProduct?.id ? 'Сохранить' : 'Создать' }}
    </Button>
  </form>
</template>
