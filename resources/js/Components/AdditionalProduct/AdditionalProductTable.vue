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
  additionalProducts: Array,
})

const confirm = useConfirm()
const withDisabled = ref(false)

const categoriesArray = computed(() => {
  if (!withDisabled.value) {
    return props.additionalProducts.filter(additionalProduct => additionalProduct.is_active)
  }

  return props.additionalProducts
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
      router.delete(route('additional-products.destroy', id))
    },
  })
}
</script>

<template>
  <div class="flex items-center gap-2">
    <Checkbox
      v-model="withDisabled"
      id="withDisabled"
      binary
    />
    <label for="withDisabled">Показать скрытые товары</label>
  </div>
  <DataTable
    dataKey="id"
    :value="categoriesArray"
  >
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
          <FontAwesomeIcon v-if="!data.is_active" :icon="['fas', 'eye-slash']" />
          {{ data.name }}
        </Link>
      </template>
    </Column>
    <Column style="width: 200px">
      <template #body="{ data }">
        <Link :href="route('additional-products.edit', data.id)">
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
