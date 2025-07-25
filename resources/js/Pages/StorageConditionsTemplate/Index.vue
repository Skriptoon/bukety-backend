<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import Block from '@/Components/Block.vue'
import ActionButtonGroup from '@/Components/ActionButtonGroup.vue'
import Button from 'primevue/button'
import StorageConditionsTemplatesTable from '@/Components/StorageConditionsTemplate/StorageConditionsTemplatesTable.vue'

defineProps({
  storageConditionsTemplates: Array,
})

const breadcrumbs = [
  {
    icon: 'fa-solid fa-house',
    to: route('dashboard'),
  },
  {
    label: 'Шаблоны условий хранения',
  },
]
</script>

<template>
  <Head>
    <title>Шаблоны условий хранения</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <ActionButtonGroup>
      <Link :href="route('storage-conditions-templates.create')">
        <Button severity="success">Добавить</Button>
      </Link>
    </ActionButtonGroup>
    <Block>
      <StorageConditionsTemplatesTable :storage-conditions-templates="storageConditionsTemplates" />
    </Block>
  </AuthenticatedLayout>
</template>
