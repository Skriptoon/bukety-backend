<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'
import Block from '@/Components/Block.vue'
import StorageConditionsTemplatesForm from '@/Components/StorageConditionsTemplate/StorageConditionsTemplatesForm.vue'

const breadcrumbs = computed(() => {
  return [
    {
      icon: 'fa-solid fa-house',
      to: route('dashboard'),
    },
    {
      label: 'Шаблоны условий хранения',
      to: route('storage-conditions-templates.index'),
    },
    {
      label: 'Создание промокода',
    },
  ]
})
</script>

<template>
  <Head>
    <title>Создание шаблона условий хранения</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <h2>Создание шаблона условий хранения</h2>
    <Block>
      <StorageConditionsTemplatesForm />
    </Block>
  </AuthenticatedLayout>
</template>
