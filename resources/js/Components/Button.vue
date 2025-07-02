<script setup>
import { computed } from "vue";

const props = defineProps({
    type: {
        type: String,
        default: "info",
    },
    label: {
        type: String,
        required: true,
    },
    route: {
        type: String,
        required: true,
    },
    id: {
        type: Number,
        default: 0,
    },
});

let link = computed(() => route(props.route, props.id));
</script>

<template>
    <a :class="'btn btn-' + type" :href="link">{{ label }}</a>
</template>

<style scoped>
.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
    text-decoration: none;
    font-weight: bold;
}
.btn-info {
    background-color: var(--color-grey); /* Blue */
    color: white;
}
.btn-info:hover {
    background-color: var(--color-dark); /* Darker grey on hover */
}
.btn-primary {
    background-color: #007bff; /* Bootstrap primary color */
    color: white;
}
.btn-primary:hover {
    background-color: #0056b3; /* Darker blue on hover */
}
.btn-danger {
    background-color: #dc3545; /* Bootstrap danger color */
    color: white;
}
.btn-danger:hover {
    background-color: #8f0e1a; /* Darker grey on hover */
}
.btn-success {
    background-color: #4caf50; /* Green */
    color: white;
}
.btn-success:hover {
    background-color: #45a049; /* Darker green on hover */
}
</style>
