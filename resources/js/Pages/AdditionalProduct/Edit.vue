<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'
import Block from '@/Components/Block.vue'
import AdditionalProductForm from '@/Components/AdditionalProduct/AdditionalProductForm.vue'

const props = defineProps({
  additionalProduct: Object,
  additionalProductTypes: Array,
})

const breadcrumbs = computed(() => {
  return [
    {
      icon: 'fa-solid fa-house',
      to: route('dashboard'),
    },
    {
      label: 'Дополнительные товары',
      to: route('additional-products.index'),
    },
    {
      label: props.additionalProduct.name,
    },
  ]
})
</script>

<template>
  <Head>
    <title>Редактирование дополнительного товара</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <h2>Создание дополнительного товара</h2>
    <Block>
      <AdditionalProductForm
        :additional-product="additionalProduct"
        :additional-product-types="additionalProductTypes"
      />
    </Block>
  </AuthenticatedLayout>
</template>
