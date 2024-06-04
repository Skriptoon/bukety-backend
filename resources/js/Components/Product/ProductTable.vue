<script setup>
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Image from 'primevue/image'
import Button from 'primevue/button'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { useConfirm } from 'primevue/useconfirm'
import { router } from '@inertiajs/vue3'
import ConfirmPopup from 'primevue/confirmpopup'

defineProps({
  products: {
    type: Array,
    required: true,
  },
})

const confirm = useConfirm()

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
</script>

<template>
  <DataTable :value="products">
    <Column
        field="image"
        style="width: 100px"
    >
      <template #body="{ data }">
        <Image imageClass="max-w-full" :src="'/storage/' + data.image"/>
      </template>
    </Column>
    <Column
        :show-filter-menu="false"
        field="name"
        header="Название"
    >
      <template #body="{ data }">
        <h4>{{ data.name }}</h4>
        <p>{{ data.preview_description }}</p>
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
              <FontAwesomeIcon icon="edit"/>
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
            <FontAwesomeIcon icon="trash"/>
          </template>
        </Button>
      </template>
    </Column>
  </DataTable>
  <ConfirmPopup/>
</template>
