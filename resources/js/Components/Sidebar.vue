<template>
  <div class="sidebar">
    <div
        class="sidebar__content"
        :class="{'sidebar__content--open' : modelValue}"
    >
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
    </div>
  </div>
</template>

<script>
import { router } from '@inertiajs/vue3'
import Icon from '@/Components/Icon.vue'

export default {
  name: 'Sidebar',

  components: {
    Icon,
  },

  props: {
    modelValue: Boolean,
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
      }
    ],
  }),

  mounted() {
    this.section = this.$page.props.selectedSection ?? 0
  },

  methods: {
    changeSection(event) {
      router.post('/change-section', {
        section: event.value,
      })
    },
  },
}
</script>
