<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Column from 'primevue/column'
import DataTable from 'primevue/datatable'
import Button from 'primevue/button'
import { router } from '@inertiajs/vue3'
import ConfirmPopup from 'primevue/confirmpopup'
import { useConfirm } from 'primevue/useconfirm'

defineProps({
  promoCodes: Array,
})

const confirm = useConfirm()

function deleteConfirm(event, id) {
  confirm.require({
    target: event.currentTarget,
    message: 'Удалить промокод?',
    icon: 'pi pi-exclamation-triangle',
    acceptLabel: 'Да',
    rejectLabel: 'Нет',
    defaultFocus: 'none',
    acceptClass: 'p-button-danger',
    accept: () => {
      router.delete(route('promo-codes.destroy', id))
    },
  })
}
</script>

<template>
  <DataTable
      :value="promoCodes"
  >
    <Column
        field="promo_code"
        header="Промокод"
    />
    <Column
        :show-filter-menu="false"
        field="promoCode.discount"
        header="Скидка"
    >
      <template #body="{ data }">
        {{ data.discount }}%
      </template>
    </Column>
    <Column style="width: 200px">
      <template #body="{ data }">
        <Link :href="route('promo-codes.edit', data.id)">
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
