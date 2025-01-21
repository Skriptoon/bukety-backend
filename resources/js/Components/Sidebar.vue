<template>
    <Drawer
        v-model:visible="visibleModel"
        :modal="false"
        :show-close-icon="false"
        :dismissable="false"
    >
        <template #header>
            Букетница
        </template>
        <i
            class="sidebar__back-button pi pi-arrow-left"
            @click="$emit('update:modelValue', false)"
        />
        <div
            v-for="(link, index) in links"
            :key="index"
            class="sidebar__link"
        >
            <Link :href="link.url" class="white-space-nowrap">
                <icon :icon="link.icon"><span class="sidebar__link-text">{{ link.title }}</span></icon>
            </Link>
        </div>
    </Drawer>
</template>

<script>
import Icon from '@/Components/Icon.vue'
import Drawer from "primevue/drawer";

export default {
  name: 'Sidebar',

  components: {
    Icon,
      Drawer
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
          }
      }
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
  }
}
</script>
