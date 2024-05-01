<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'
import CategoryForm from '@/Components/Category/CategoryForm.vue'
import Block from '@/Components/Block.vue'

const props = defineProps({
  category: Object,
})

const breadcrumbs = computed(() => {
  return [
    {
      icon: 'pi pi-home',
      to: route('dashboard'),
    },
    {
      label: 'Категории',
      to: route('categories.index'),
    },
    {
      label: 'Создание категории',
    },
  ]
})
</script>

<template>
  <Head>
    <title>Создание категории</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <h2>Создание категории</h2>
    <Block>
      <CategoryForm :category="category" />
    </Block>
  </AuthenticatedLayout>
</template>
