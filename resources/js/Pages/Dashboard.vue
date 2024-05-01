<template>
    <AuthenticatedLayout :breadcrumb="breadcrumb">
        <div class="dashboard grid">
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

export default {
    components: {
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
