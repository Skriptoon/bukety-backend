<template>
  <Drawer
      v-model:visible="visibleModel"
      :modal="false"
      :show-close-icon="!isLg"
      :dismissable="false"
  >
    <template #header>
      <div class="flex items-center justify-between px-6 pt-4 shrink-0">
                <span class="inline-flex items-center gap-2">
                    <img width="30" src="/storage/images/logo.png" alt="logo"/>
                    <span class="font-semibold text-2xl text-primary">Букетница</span>
                </span>
      </div>
    </template>
    <i
        class="sidebar__back-button pi pi-arrow-left"
        @click="$emit('update:modelValue', false)"
    />
    <div
        v-for="(link, index) in links"
        :key="index"
        class="p-2 text-xl"
    >
      <Link :href="link.url" class="white-space-nowrap">
        <icon :icon="link.icon"><span class="ml-2">{{ link.title }}</span></icon>
      </Link>
    </div>
  </Drawer>
</template>

<script>
import Icon from '@/Components/Icon.vue'
import Drawer from 'primevue/drawer';

export default {
  name: 'Sidebar',

  components: {
    Icon,
    Drawer,
  },

  props: {
    modelValue: Boolean,
    visible: Boolean,
  },

  computed: {
    visibleModel: {
      get() {
        return this.visible
      },
      set(value) {
        this.$emit('update:visible', value)
      },
    },

    isLg() {
      return window.innerWidth > 1024
    },
  },

  data: () => ({
    section: null,

    links: [
      {
        url: route('dashboard'),
        title: 'Главная',
        icon: 'home',
      },
      {
        url: route('products.index'),
        title: 'Товары',
        icon: 'shopping-bag',
      },
      {
        url: route('categories.index'),
        title: 'Категории',
        icon: 'list',
      },
      {
        url: route('orders.index'),
        title: 'Заказы',
        icon: 'cart-shopping',
      },
      {
        url: route('promo-codes.index'),
        title: 'Промокоды',
        icon: 'percent',
      },
    ],
  }),

  mounted() {
    this.section = this.$page.props.selectedSection ?? 0
  },
}
</script>
