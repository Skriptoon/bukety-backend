<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import ProductForm from '@/Components/Product/ProductForm.vue'
import {computed} from 'vue'
import Block from '@/Components/Block.vue'
import {Head} from '@inertiajs/vue3'

defineProps({
  categories: Array,
  whomOptions: Array,
  occasionOptions: Array,
  units: Array,
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
      label: 'Создание товара',
    },
  ]
})
</script>

<template>
  <Head>
    <title>Создание товара</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <h2>Создание товара</h2>
    <Block>
      <ProductForm
          :categories="categories"
          :occasion-options="occasionOptions"
          :whom-options="whomOptions"
          :units="units"
      />
    </Block>
  </AuthenticatedLayout>
</template>
