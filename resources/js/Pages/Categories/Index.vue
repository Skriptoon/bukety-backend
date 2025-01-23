<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Block from '@/Components/Block.vue'
import CategoryTable from '@/Components/Category/CategoryTable.vue'
import {Head} from '@inertiajs/vue3'
import ActionButtonGroup from '@/Components/ActionButtonGroup.vue'
import Button from 'primevue/button'

defineProps({
  categories: Array,
})

const breadcrumbs = [
  {
    icon: 'fa-solid fa-house',
    to: route('dashboard'),
  },
  {
    label: 'Категории',
  },
]
</script>

<template>
  <Head>
    <title>Категории</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <ActionButtonGroup>
      <Link :href="route('categories.create')">
        <Button severity="success">Добавить</Button>
      </Link>
    </ActionButtonGroup>
    <Block>
      <CategoryTable :categories="categories" />
    </Block>
  </AuthenticatedLayout>
</template>
