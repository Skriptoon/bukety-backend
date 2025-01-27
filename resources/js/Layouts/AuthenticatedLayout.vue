<template>
  <div v-if="userLoaded" class="authenticated-layout">
    <i
        class="authenticated-layout__bar-icon pi pi-bars"
        @click="openSidebar = true"
    />
    <Sidebar v-model="openSidebar" v-model:visible="visibleSidebar"/>
    <header
        class="authenticated-layout__header transition-[margin-left] duration-300 ml-0 flex items-center px-4"
        :class="{
          '!ml-[330px]': visibleSidebar && isLg,
        }"
    >
      <Button @click="toggleSidebar">
        <Icon icon="fa-solid fa-bars"/>
      </Button>
      <div class="flex justify-content-between flex-wrap card-container">
        <div class="authenticated-layout__breadcrumbs">
          <breadcrumb :model="breadcrumb" class="!bg-transparent">
            <template #item="{item}">
              <Link
                  class="p-menuitem-link"
                  :href="item.to ?? ''"
              >
                <Icon
                    v-if="item.icon"
                    :icon="item.icon"
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
    <main
        class="authenticated-layout__content transition-[margin-left] duration-300 ml-0 p-4"
        :class="{
          '!ml-[330px]': visibleSidebar  && isLg,
        }"
    >
      <slot/>
    </main>
    <Toast position="top-center" group="tc"/>
  </div>
</template>

<script>
import Sidebar from '@/Components/Sidebar.vue'
import Breadcrumb from 'primevue/breadcrumb'
import Toast from 'primevue/toast';
import Button from 'primevue/button';
import Icon from '@/Components/Icon.vue';

export default {
  name: 'AuthenticatedLayout',

  components: {
    Icon,
    Breadcrumb,
    Sidebar,
    Toast,
    Button,
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

    isLg() {
      return window.innerWidth > 1024
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

    if (localStorage.getItem('visibleSidebar') !== null) {
      this.visibleSidebar = Boolean(Number(localStorage.getItem('visibleSidebar')))
    }

    if (!this.isLg) {
      this.visibleSidebar = false
    }
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
      visibleSidebar: true,
    }
  },

  methods: {
    toggleSidebar() {
      this.visibleSidebar = !this.visibleSidebar
      localStorage.setItem('visibleSidebar', Number(this.visibleSidebar))
    },
  },
}
</script>
