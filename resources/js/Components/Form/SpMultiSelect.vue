<template>
    <div>
        <div class="p-float-label">
            <MultiSelect
                v-model="modelValue[name]"
                :id="name"
                :options="options"
                :class="{ 'p-invalid': modelValue.errors[name] }"
                display="chip"
                option-label="name"
                option-value="value"
                placeholder="Не выбрано"
                aria-describedby="dd-error"
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
import MultiSelect from 'primevue/multiselect';

export default {
    name: 'SpMultiSelect',

    components: {
        MultiSelect,
    },

    props: {
        modelValue: Object,

        options: Array,
        name: String,
        label: String,
    },
};
</script>
