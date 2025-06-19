<script setup>
import Button from 'primevue/button'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import ActionButtonGroup from '@/Components/ActionButtonGroup.vue'
import Block from '@/Components/Block.vue'
import { Head } from '@inertiajs/vue3'
import AdditionalProductTable from '@/Components/AdditionalProduct/AdditionalProductTable.vue'

defineProps({
  additionalProducts: {
    type: Array,
    required: true,
  },
})

const breadcrumbs = [
  {
    icon: 'fa-solid fa-house',
    to: route('dashboard'),
  },
  {
    label: 'Дополнительные товары',
  },
]
</script>

<template>
  <Head>
    <title>Дополнительные товары</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <ActionButtonGroup>
      <Link :href="route('additional-products.create')">
        <Button severity="success">Добавить</Button>
      </Link>
    </ActionButtonGroup>
    <Block>
      <AdditionalProductTable :additional-products="additionalProducts" />
    </Block>
  </AuthenticatedLayout>
</template>
