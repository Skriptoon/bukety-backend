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
        v-model="form.promo_code"
        :error="form.errors.promo_code"
        label="Промокод"
        name="promo_code"
        @reset-validation="form.errors.promo_code = null"
      />
    </div>
    <div class="mt-5">
      <SpInput
        v-model="form.discount"
        :error="form.errors.discount"
        :max="99"
        :min="1"
        label="Скидка"
        name="discount"
        number
        suffix="%"
        @reset-validation="form.errors.discount = null"
      />
    </div>
    <div class="mt-5">
      <SpDatePicker
        v-model="form.expired_at"
        :error="form.errors.expired_at"
        :min-date="new Date()"
        label="Действует до"
        name="expired_at"
        @reset-validation="form.errors.expired_at = null"
      />
    </div>
    <div class="mt-5">
      <SpCheckbox
        v-model="form.is_disposable"
        label="Одноразовый"
        name="is_disposable"
        switcher
      />
    </div>
    <div class="mt-5">
      <SpCheckbox
        v-model="form.is_active"
        label="Активна"
        name="is_active"
        switcher
      />
    </div>
    <Button
      class="mt-2"
      severity="success"
      type="submit"
    >
      {{ promoCode?.id ? 'Сохранить' : 'Создать' }}
    </Button>
  </form>
</template>
