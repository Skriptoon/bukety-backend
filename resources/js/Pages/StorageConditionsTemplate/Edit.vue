<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'
import Block from '@/Components/Block.vue'
import StorageConditionsTemplatesForm from '@/Components/StorageConditionsTemplate/StorageConditionsTemplatesForm.vue'

const props = defineProps({
  storageConditionsTemplate: Object,
})

const breadcrumbs = computed(() => {
  return [
    {
      icon: 'fa-solid fa-house',
      to: route('dashboard'),
    },
    {
      label: 'Шаблоны условий хранения',
      to: route('promo-codes.index'),
    },
    {
      label: props.storageConditionsTemplate.name,
    },
  ]
})
</script>

<template>
  <Head>
    <title>Изменение шаблона условий хранения</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <h2>Изменение шаблона условий хранения</h2>
    <Block>
      <StorageConditionsTemplatesForm :storage-conditions-template="storageConditionsTemplate" />
    </Block>
  </AuthenticatedLayout>
</template>
