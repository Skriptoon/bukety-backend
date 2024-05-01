<template>
    <div>
        <div class="p-float-label mb-2">
            <Password
                v-model="modelValue[name]"
                class="w-full"
                :id="name"
                :feedback="feedback"
                :class="{'p-invalid': modelValue.errors[name]}"
                :aria-describedby="name"
                toggleMask
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
import Password from 'primevue/password';

export default {
    name: 'SpPassword',

    components: {
        Password,
    },

    props: {
        modelValue: Object,

        label: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
        feedback: Boolean,
    },
};
</script>
