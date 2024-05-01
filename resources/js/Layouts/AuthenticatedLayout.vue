<template>
  <div v-if="userLoaded" class="authenticated-layout">
    <i
        class="authenticated-layout__bar-icon pi pi-bars"
        @click="openSidebar = true"
    />
    <sidebar v-model="openSidebar"/>
    <header class="authenticated-layout__header">
      <div class="authenticated-layout__user-menu">
        <menubar :model="menu">
          <template #item="{item}">
            <Link
                v-if="item.to"
                :href="item.to"
                class="p-menuitem-link"
            >{{ item.label }}
            </Link>
            <span
                v-else
                class="p-menuitem-link"
            >{{ item.label }}</span>
          </template>
        </menubar>
      </div>
      <div class="flex justify-content-between flex-wrap card-container">
        <div class="authenticated-layout__breadcrumbs">
          <breadcrumb :model="breadcrumb">
            <template #item="{item}">
              <Link
                  class="p-menuitem-link"
                  :href="item.to ?? ''"
              >
                <span
                    v-if="item.icon"
                    :class="item.icon"
                />
                <span
                    v-if="item.label"
                    class="p-menuitem-text"
                >
                    {{ item.label }}
                </span>
              </Link>
            </template>
          </breadcrumb>
        </div>
      </div>
    </header>
    <main class="authenticated-layout__content">
      <slot/>
    </main>
    <Toast position="top-center" group="tc"/>
  </div>
</template>

<script>
import Sidebar from '@/Components/Sidebar.vue'
import Breadcrumb from 'primevue/breadcrumb'
import Menubar from 'primevue/menubar'
import Toast from 'primevue/toast';

export default {
  name: 'AuthenticatedLayout',

  components: {
    Breadcrumb,
    Sidebar,
    Menubar,
    Toast,
  },

  props: {
    breadcrumb: {
      type: Object,
      request: true,
    },
  },

  computed: {
    userLoaded() {
      return this.$page.props.auth.user
    },
  },

  mounted() {
    const ctx = this
    this.$inertia.on('invalid', (event) => {
      if (event.detail.response.data.success === false) {
        event.preventDefault()
        ctx.$toast.add({
          severity: 'error',
          summary: 'Ошибка',
          detail: event.detail.response.data.error,
          group: 'tc',
          life: 3000,
        })
      }
    })
  },

  data() {
    return {
      menu: [
        {
          label: this.$page.props.auth.user.name,
          items: [
            {
              label: 'Выход',
              to: this.route('logout'),
            },
          ],
        },
      ],
      openSidebar: false,
    }
  },
}
</script>
