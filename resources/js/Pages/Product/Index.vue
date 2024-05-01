<script>
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import ProductTable from '@/Components/Product/ProductTable.vue'
import { defineComponent } from 'vue'
import Block from '@/Components/Block.vue'
import ActionButtonGroup from '@/Components/ActionButtonGroup.vue'
import Button from 'primevue/button'

export default defineComponent({
  components: {
    ActionButtonGroup,
    Head,
    AuthenticatedLayout,
    ProductTable,
    Block,
    Button,
  },

  data: () => ({
    breadcrumbs: [
      {
        icon: 'pi pi-home',
        to: route('dashboard'),
      },
      {
        label: 'Товары',
      },
    ],
  }),

  props: {
    products: Array,
  },
})
</script>

<template>
  <Head>
    <title>Товары</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumbs">
    <ActionButtonGroup>
      <Link :href="route('products.create')">
        <Button severity="success">Добавить</Button>
      </Link>
    </ActionButtonGroup>
    <Block>
      <ProductTable :products="products"/>
    </Block>
  </AuthenticatedLayout>
</template>
