<template>
    <div>
        <div class="p-float-label mb-2">
            <dropdown
                v-model="modelValue[name]"
                class="w-full"
                :options="options"
                :id="name"
                option-label="name"
                option-value="id"
                :class="{'p-invalid': modelValue.errors[name]}"
                @focus="modelValue.errors[name] = null"
            />
            <label :for="name">{{ label }}</label>
        </div>
        <small
            v-if="modelValue.errors[name]"
            :id="name"
            class="p-error"
        >
            {{ modelValue.errors[name] }}
        </small>
    </div>
</template>

<script>
import Dropdown from 'primevue/dropdown';

export default {
    name: 'SpDropdown',

    components: {
        Dropdown,
    },

    props: {
        modelValue: Object,
        name: {
            type: String,
            required: true,
        },
        label: String,
        options: {
            type: Array,
            required: true,
        },

    },
};
</script>

<style scoped>

</style>
