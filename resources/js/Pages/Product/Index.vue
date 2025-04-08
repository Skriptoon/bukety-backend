<script setup>
import {Head} from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import ProductTable from '@/Components/Product/ProductTable.vue'
import Block from '@/Components/Block.vue'
import ActionButtonGroup from '@/Components/ActionButtonGroup.vue'
import Button from 'primevue/button'

defineProps({
  products: Array,
  categories: Array,
  vkProductFeed: String,
})

const breadcrumbs = [
  {
    icon: 'fa-solid fa-house',
    to: route('dashboard'),
  },
  {
    label: 'Товары',
  },
]
</script>

<template>
  <Head>
    <title>Товары</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    Сслыка на товары для ВК: {{ vkProductFeed }}
    <ActionButtonGroup>
      <Link :href="route('products.create')">
        <Button severity="success">Добавить</Button>
      </Link>
    </ActionButtonGroup>
    <Block>
      <ProductTable :products="products" :categories="categories" />
    </Block>
  </AuthenticatedLayout>
</template>
