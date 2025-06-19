<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'
import Block from '@/Components/Block.vue'
import AdditionalProductForm from '@/Components/AdditionalProduct/AdditionalProductForm.vue'

defineProps({
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
      label: 'Создание дополнительного товара',
    },
  ]
})
</script>

<template>
  <Head>
    <title>Создание дополнительного товара</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <h2>Создание дополнительного товара</h2>
    <Block>
      <AdditionalProductForm :additional-product-types="additionalProductTypes"/>
    </Block>
  </AuthenticatedLayout>
</template>
