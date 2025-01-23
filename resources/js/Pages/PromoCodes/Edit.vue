<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import {Head} from '@inertiajs/vue3'
import {computed} from 'vue'
import Block from '@/Components/Block.vue'
import PromoCodesForm from '@/Components/PromoCodes/PromoCodesForm.vue'

const props = defineProps({
  promoCode: Object,
})

const breadcrumbs = computed(() => {
  return [
    {
      icon: 'fa-solid fa-house',
      to: route('dashboard'),
    },
    {
      label: 'Промокоды',
      to: route('promo-codes.index'),
    },
    {
      label: props.promoCode.promo_code,
    },
  ]
})
</script>

<template>
  <Head>
    <title>Редактирование промокода</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <h2>Редактирование промокода</h2>
    <Block>
      <PromoCodesForm :promo-code="promoCode"/>
    </Block>
  </AuthenticatedLayout>
</template>
