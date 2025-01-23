<script setup>
import OrderTable from '@/Components/Order/OrderTable.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import {Head} from '@inertiajs/vue3'
import Block from '@/Components/Block.vue'

const breadcrumbs = [
  {
    icon: 'fa-solid fa-house',
    to: route('dashboard'),
  },
  {
    label: 'Заказы',
  },
]

defineProps({
  orders: Object,
  communicationMethods: Object,
})
</script>

<template>
  <Head>
    <title>Заказы</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <Block>
      <OrderTable :orders="orders" :communication-methods="communicationMethods"/>
    </Block>
  </AuthenticatedLayout>
</template>
