<script setup>
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Button from 'primevue/button'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { router } from '@inertiajs/vue3'
import Image from 'primevue/image'
import ConfirmPopup from 'primevue/confirmpopup'
import { useConfirm } from 'primevue/useconfirm'

defineProps({
  categories: Array,
})

const confirm = useConfirm()

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
</script>

<template>
  <DataTable :value="categories">
    <Column
        field="image"
        style="width: 100px"
    >
      <template #body="{ data }">
        <Image v-if="data.image" imageClass="max-w-full" :src="'/storage/' + data.image"/>
      </template>
    </Column>
    <Column
        field="name"
        header="Название"
    />
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
  </DataTable>
  <ConfirmPopup />
</template>
