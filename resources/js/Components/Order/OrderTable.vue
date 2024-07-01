<script setup>
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import { router } from '@inertiajs/vue3'
import Button from 'primevue/button'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

defineProps({
  orders: Object,
  communicationMethods: Object,
})

function getRouteParams() {
  const params = {}

  for (const param in filters.value) {
    params[param] = filters.value[param].value
  }

  return params
}

function filter() {
  router.get(route('orders.index'), getRouteParams(), {
    only: ['products'],
  })
}

function page(data) {
  const params = getRouteParams()
  params.page = data.page + 1
  params.per_page = data.rows

  router.get(route('orders.index'), params, {
    only: ['products'],
  })
}

function completeOrder(id) {
  router.patch(route('orders.complete', id))
}
</script>

<template>
  <DataTable
      :value="orders.data"
      :rows="orders.per_page"
      :first="orders.from"
      :rowsPerPageOptions="[5, 10, 20, 50]"
      :total-records="orders.total"
      filterDisplay="row"
      paginator
      lazy
      @filter="filter"
      @page="page"
  >
    <Column
        field="name"
        header="Имя"
    />
    <Column
        :show-filter-menu="false"
        field="phone"
        header="Телефон"
    />
    <Column
        :show-filter-menu="false"
        field="product.id"
        header="Товар"
    >
      <template #body="{ data }">
        <Link :href="route('products.edit', data.product.id)">
          {{ data.product.name }}
        </Link>
      </template>
    </Column>
    <Column
        :show-filter-menu="false"
        field="communication_method"
        header="Способ связи"
    >
      <template #body="{ data }">
        {{ communicationMethods[data.communication_method] }}
      </template>
    </Column>
    <Column style="width: 200px">
      <template #body="{ data }">
          <Button
              v-tooltip.bottom="'Завершить'"
              class="p-button-primary"
              @click="completeOrder(data.id)"
          >
            <template #icon>
              <FontAwesomeIcon icon="check" />
            </template>
          </Button>
      </template>
    </Column>
  </DataTable>
</template>
