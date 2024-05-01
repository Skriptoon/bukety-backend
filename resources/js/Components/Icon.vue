<template>
    <font-awesome-icon :icon="icon"/>
    <slot/>
</template>

<script>
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';

export default {
    name: 'Icon',

    components: {FontAwesomeIcon},

    props: {
        icon: {
            required: true,
            type: [Array, String],
        },
    },
};
</script>
