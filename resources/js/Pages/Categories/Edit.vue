<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import {Head} from '@inertiajs/vue3'
import {computed} from 'vue'
import CategoryForm from '@/Components/Category/CategoryForm.vue'
import Block from '@/Components/Block.vue'

const props = defineProps({
  category: Object,
  categories: Array,
})

const breadcrumbs = computed(() => {
  return [
    {
      icon: 'fa-solid fa-house',
      to: route('dashboard'),
    },
    {
      label: 'Категории',
      to: route('categories.index'),
    },
    {
      label: props.category.name,
    },
  ]
})
</script>

<template>
  <Head>
    <title>Редактирование категории</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <h2>Редактирование категории</h2>
    <Block>
      <CategoryForm :category="category" :categories="categories"/>
    </Block>
  </AuthenticatedLayout>
</template>
