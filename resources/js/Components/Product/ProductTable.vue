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
import { onMounted, ref } from 'vue'
import { FilterMatchMode } from '@primevue/core/api'
import InputText from 'primevue/inputtext'
import { Inertia } from '@inertiajs/inertia'
import Checkbox from 'primevue/checkbox'
import Select from 'primevue/select'

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

let getParams = (new URL(document.location)).searchParams

const filters = ref({
  category: {
    value: getParams.get('category') ? Number(getParams.get('category')) : null,
    matchMode: FilterMatchMode.CONTAINS,
  },
  name: {value: getParams.get('name'), matchMode: FilterMatchMode.CONTAINS},
})

let nameFilterInput = ref(null)
const withDisabled = ref(Boolean(Number(getParams.get('with_disabled'))))

onMounted(() => {
  const nameFilter = Inertia.restore('nameFilter')
  if (getParams.get('name') !== String(nameFilter)) {
    nameFilterInput.value.$el.focus()
  }
  Inertia.remember('nameFilter', getParams.get('name'))
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
  params.with_disabled = Number(withDisabled.value)

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
  const params = getRouteParams()
  params.page = data.page + 1
  params.per_page = data.rows

  router.get(route('products.index'), params, {
    only: ['products'],
  })
}
</script>

<template>
  <div class="flex items-center gap-2">
    <Checkbox
      v-model="withDisabled"
      id="withDisabled"
      binary
      @update:modelValue="filter"
    />
    <label for="withDisabled">Показать скрытые товары</label>
  </div>
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
        <a :href="route('get-image-with-description', data.id)" target="_blank">
          <Image
            :src="'/storage/' + data.image"
            image-class="max-w-none"
            width="70"
            height="70"
          />
        </a>
      </template>
    </Column>
    <Column
      :show-filter-menu="false"
      field="name"
      header="Название"
    >
      <template #filter="{ filterModel, filterCallback }">
        <InputText ref="nameFilterInput" v-model="filterModel.value" @input="filterCallback" />
      </template>
      <template #body="{ data }">
        <Link :href="route('products.edit', data.id)">
          <h4>
            <FontAwesomeIcon v-if="!data.is_active" :icon="['fas', 'eye-slash']" />
            {{ data.name }}
          </h4>
          <p>Цена: {{ data.price }}₽</p>
        </Link>
      </template>
    </Column>
    <Column
      :show-filter-menu="false"
      field="category"
      header="Категории"
    >
      <template #filter="{ filterModel, filterCallback }">
        <Select
          v-model="filterModel.value"
          :options="categories"
          option-label="name"
          option-value="id"
          placeholder="Выбрать категорию"
          class="p-column-filter"
          style="min-width: 12rem"
          :showClear="true"
          filter
          @change="filterCallback()"
        >
        </Select>
      </template>
      <template #body="{ data }">
        <div class="flex gap-1 flex-wrap">
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
