<template>
  <Head>
    <title>Главная</title>
  </Head>
  <AuthenticatedLayout :breadcrumb="breadcrumb">
    <div class="dashboard grid">
    </div>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'

export default {
  components: {
    Head,
    AuthenticatedLayout,
  },

  data() {
    return {
      breadcrumb: [
        {
          icon: 'pi pi-home',
        },
      ],
    }
  },
}
</script>
