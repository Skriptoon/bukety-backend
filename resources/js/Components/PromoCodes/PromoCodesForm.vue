<script setup>
import { useForm } from '@inertiajs/vue3'
import SpInput from '@/Components/Form/SpInput.vue'
import Button from 'primevue/button'
import SpCheckbox from '@/Components/Form/SpCheckbox.vue'
import SpDatePicker from '@/Components/Form/SpDatePicker.vue'

const props = defineProps({
  promoCode: Object,
})

const form = useForm({
  id: props.promoCode?.id ?? null,
  promo_code: props.promoCode?.promo_code ?? null,
  discount: props.promoCode?.discount ?? null,
  expired_at: props.promoCode?.expired_at ? new Date(props.promoCode?.expired_at) : null,
  is_active: props.promoCode?.is_active ?? false,
  is_disposable: props.promoCode?.is_disposable ?? false,
  _method: undefined,
})

function sendForm() {
  if (props.promoCode?.id) {
    form._method = 'PUT'
    form.post(route('promo-codes.update', props.promoCode.id))
  } else {
    form.post(route('promo-codes.store'))
  }
}
</script>

<template>
  <form @submit.prevent="sendForm">
    <div class="mt-2">
      <SpInput
          v-model="form"
          name="promo_code"
          label="Промокод"
      />
    </div>
    <div class="mt-5">
      <SpInput
          v-model="form"
          name="discount"
          label="Скидка"
          suffix="%"
          :max="99"
          :min="1"
          number
      />
    </div>
    <div class="mt-5">
      <SpDatePicker
          v-model="form"
          name="expired_at"
          label="Действует до"
          :min-date="new Date()"
      />
    </div>
    <div class="mt-5">
      <SpCheckbox
          v-model="form"
          name="is_disposable"
          label="Одноразовый"
          switcher
      />
    </div>
    <div class="mt-5">
      <SpCheckbox
          v-model="form"
          name="is_active"
          label="Активна"
          switcher
      />
    </div>
    <Button
        severity="success"
        class="mt-2"
        type="submit"
    >
      {{ promoCode?.id ? 'Сохранить' : 'Создать' }}
    </Button>
  </form>
</template>
