<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'
import Block from '@/Components/Block.vue'
import PromoCodesForm from '@/Components/PromoCodes/PromoCodesForm.vue'

const breadcrumbs = computed(() => {
  return [
    {
      icon: 'pi pi-home',
      to: route('dashboard'),
    },
    {
      label: 'Промокоды',
      to: route('promo-codes.index'),
    },
    {
      label: 'Создание промокода',
    },
  ]
})
</script>

<template>
  <Head>
    <title>Создание промокода</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <h2>Создание промокода</h2>
    <Block>
      <PromoCodesForm/>
    </Block>
  </AuthenticatedLayout>
</template>
