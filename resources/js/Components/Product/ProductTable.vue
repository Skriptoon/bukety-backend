<script setup>
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Image from 'primevue/image'
import Button from 'primevue/button'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { useConfirm } from 'primevue/useconfirm'
import { router } from '@inertiajs/vue3'
import ConfirmPopup from 'primevue/confirmpopup'
import Tag from 'primevue/tag'
import Dropdown from 'primevue/dropdown'
import { ref } from 'vue'
import { FilterMatchMode } from 'primevue/api'
import InputText from 'primevue/inputtext'

defineProps({
  products: {
    type: Array,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
})

const confirm = useConfirm()

let getParams = (new URL(document.location)).searchParams;

const filters = ref({
  category: { value: getParams.get('category'), matchMode: FilterMatchMode.CONTAINS },
  name: { value: getParams.get('name'), matchMode: FilterMatchMode.CONTAINS },
})

function deleteConfirm(event, id) {
  confirm.require({
    target: event.currentTarget,
    message: 'Удалить товар?',
    icon: 'pi pi-exclamation-triangle',
    acceptLabel: 'Да',
    rejectLabel: 'Нет',
    defaultFocus: 'none',
    acceptClass: 'p-button-danger',
    accept: () => {
      router.delete(route('products.destroy', id))
    },
  })
}

function getRouteParams() {
  const params = {}

  for (const param in filters.value) {
    params[param] = filters.value[param].value
  }

  return params
}

function filter() {
  router.get(route('products.index'), getRouteParams(), {
    only: ['products'],
  })
}

function page(data) {
  console.log(data)
  const params = getRouteParams()
  params.page = data.page + 1
  params.per_page = data.rows

  router.get(route('products.index'), params, {
    only: ['products'],
  })
}
</script>

<template>
  <DataTable
    v-model:filters="filters"
    :value="products.data"
    :rows="products.per_page"
    :first="products.from"
    :rowsPerPageOptions="[5, 10, 20, 50]"
    :total-records="products.total"
    filterDisplay="row"
    paginator
    lazy
    @filter="filter"
    @page="page"
  >
    <Column
      field="image"
      style="width: 100px"
    >
      <template #body="{ data }">
        <Image
          imageClass="max-w-full"
          :src="'/storage/' + data.image"
        />
      </template>
    </Column>
    <Column
      :show-filter-menu="false"
      field="name"
      header="Название"
    >
      <template #filter="{ filterModel, filterCallback }">
        <InputText v-model.trim="filterModel.value" @input="filterCallback" />
      </template>
      <template #body="{ data }">
        <h4>{{ data.name }}</h4>
        <p>{{ data.preview_description }}</p>
      </template>
    </Column>
    <Column
      :show-filter-menu="false"
      field="category"
      header="Категории"
    >
      <template #filter="{ filterModel, filterCallback }">
        <Dropdown
          v-model="filterModel.value"
          :options="categories"
          option-label="name"
          option-value="id"
          placeholder="Выбрать категорию"
          class="p-column-filter"
          style="min-width: 12rem"
          :showClear="true"
          @change="filterCallback()"
        >
        </Dropdown>
      </template>
      <template #body="{ data }">
        <div class="grid gap-1">
          <Tag
            v-for="(category, index) in data.categories"
            :key="index"
          >
            {{ category.name }}
          </Tag>
        </div>
      </template>
    </Column>
    <Column style="width: 200px">
      <template #body="{ data }">
        <Link :href="route('products.edit', data.id)">
          <Button
            v-tooltip.bottom="'Измеить'"
            class="p-button-primary"
          >
            <template #icon>
              <FontAwesomeIcon icon="edit" />
            </template>
          </Button>
        </Link>
        <Button
          v-tooltip.bottom="'Удалить'"
          class="ml-2"
          severity="danger"
          @click="deleteConfirm($event, data.id)"
        >
          <template #icon>
            <FontAwesomeIcon icon="trash" />
          </template>
        </Button>
      </template>
    </Column>
  </DataTable>
  <ConfirmPopup />
</template>
