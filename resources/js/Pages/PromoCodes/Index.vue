<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import Block from '@/Components/Block.vue'
import ActionButtonGroup from '@/Components/ActionButtonGroup.vue'
import PromoCodesTable from '@/Components/PromoCodes/PromoCodesTable.vue'
import Button from 'primevue/button'

defineProps({
  promoCodes: Array,
})

const breadcrumbs = [
  {
    icon: 'pi pi-home',
    to: route('dashboard'),
  },
  {
    label: 'Промокоды',
  },
]
</script>

<template>
  <Head>
    <title>Промокоды</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <ActionButtonGroup>
      <Link :href="route('promo-codes.create')">
        <Button severity="success">Добавить</Button>
      </Link>
    </ActionButtonGroup>
    <Block>
      <PromoCodesTable :promo-codes="promoCodes" />
    </Block>
  </AuthenticatedLayout>
</template>
