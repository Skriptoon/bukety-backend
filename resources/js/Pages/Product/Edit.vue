<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import ProductForm from '@/Components/Product/ProductForm.vue'
import { computed } from 'vue'
import Block from '@/Components/Block.vue'
import { Head } from '@inertiajs/vue3'

const props = defineProps({
  product: Object,
  categories: Array,
  whomOptions: Array,
  occasionOptions: Array,
  units: Array,
  previousUrl: String,
  storageConditionsTemplates: Array,
})

const breadcrumbs = computed(() => {
  return [
    {
      icon: 'fa-solid fa-house',
      to: route('dashboard'),
    },
    {
      label: 'Товары',
      to: route('products.index'),
    },
    {
      label: props.product.name,
    },
  ]
})
</script>

<template>
  <Head>
    <title>Редактирование товара</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <h2>Редактирование товара</h2>
    <Block>
      <ProductForm
        :product="product"
        :categories="categories"
        :occasion-options="occasionOptions"
        :whom-options="whomOptions"
        :units="units"
        :previous-url="previousUrl"
        :storage-conditions-templates="storageConditionsTemplates"
      />
    </Block>
  </AuthenticatedLayout>
</template>
