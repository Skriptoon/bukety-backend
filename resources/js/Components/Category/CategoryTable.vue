<script setup>
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Button from 'primevue/button'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { router } from '@inertiajs/vue3'
import Image from 'primevue/image'
import ConfirmPopup from 'primevue/confirmpopup'
import { useConfirm } from 'primevue/useconfirm'
import { computed, ref } from 'vue'
import Checkbox from 'primevue/checkbox'

const props = defineProps({
  categories: Array,
  isChild: Boolean,
})

const confirm = useConfirm()
const expandedRows = ref([])
const withDisabled = ref(false)

const categoriesArray = computed(() => {
  if (!withDisabled.value) {
    return props.categories.filter(category => category.is_active && !category.is_hidden)
  }
  return props.categories
})

function deleteConfirm(event, id) {
  confirm.require({
    target: event.currentTarget,
    message: 'Удалить категорию?',
    icon: 'pi pi-exclamation-triangle',
    acceptLabel: 'Да',
    rejectLabel: 'Нет',
    defaultFocus: 'none',
    acceptClass: 'p-button-danger',
    accept: () => {
      router.delete(route('categories.destroy', id))
    },
  })
}

function onRowReorder(event) {
  categoriesArray.value = event.value

  axios.patch(route('categories.update-sort'), {
    category_ids: event.value.map(category => category.id),
  })

  expandedRows.value = []
}
</script>

<template>
  <div v-if="!isChild" class="flex items-center gap-2">
    <Checkbox
      v-model="withDisabled"
      id="withDisabled"
      binary
    />
    <label for="withDisabled">Показать скрытые категории</label>
  </div>
  <DataTable
    v-model:expandedRows="expandedRows"
    dataKey="id"
    :value="categoriesArray"
    @rowReorder="onRowReorder"
  >
    <Column rowReorder headerStyle="width: 3rem" :reorderableColumn="false" />
    <Column expander style="width: 5rem" />
    <Column
      field="image"
      style="width: 100px"
    >
      <template #body="{ data }">
        <Image v-if="data.image" imageClass="max-w-full" :src="'/storage/' + data.image" />
      </template>
    </Column>
    <Column
      field="name"
      header="Название"
    >
      <template #body="{ data }">
        <Link :href="route('categories.edit', data.id)">
          <FontAwesomeIcon v-if="data.is_hidden" :icon="['fas', 'eye-slash']" />
          {{ data.name }}
        </Link>
      </template>
    </Column>
    <Column style="width: 200px">
      <template #body="{ data }">
        <Link :href="route('categories.edit', data.id)">
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
    <template #expansion="{ data }">
      <div class="border-1 border-400 border-round-lg">
        <CategoryTable :categories="data.children" is-child/>
      </div>
    </template>
  </DataTable>
  <ConfirmPopup />
</template>
