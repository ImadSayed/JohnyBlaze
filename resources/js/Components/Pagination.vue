<script setup>
defineProps({
    data: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="pagination-wrapper">
        <div class="pagination-body">
            <p class="pagination-text">
                Showing
                <span class="pagination-count">
                    {{ data.meta.from ?? 0 }}
                </span>
                to
                <span class="pagination-increment">
                    {{ data.meta.to ?? 0 }}
                </span>
                of
                <span class="pagination-total">
                    {{ data.meta.total ?? 0 }}
                </span>
                {{ data.meta.total === 1 ? "result" : "results" }}
            </p>

            <nav class="pagination-list" aria-label="Pagination Navigation">
                <button
                    class="pagination-button"
                    v-for="link in data.meta.links"
                    v-bind:key="link.label"
                    v-bind:class="{
                        '--active': link.active,
                        '--disabled': !link.url,
                    }"
                >
                    <span v-html="link.label"></span>
                </button>
            </nav>
        </div>
    </div>
</template>

<style scoped>
.pagination-wrapper {
    padding: 1rem 3rem;
}
.pagination-body {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 2rem;
}
.pagination-text {
    font-size: 0.875rem;
    color: var(--color-gray-600);
}
.pagination-count,
.pagination-increment,
.pagination-total {
    font-weight: 600;
    color: var(--color-gray-800);
}
.pagination-list {
    display: flex;
    gap: 0.5rem;
}
.pagination-button {
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    background-color: var(--color-white);
    color: var(--color-grey);
    font-size: 0.875rem;
    font-weight: 400;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}
.pagination-button:hover {
    background-color: var(--color-yellow);
    color: var(--color-dark);
}
.pagination-button.--active {
    background-color: var(--color-white);
    color: var(--color-green);
    font-weight: 600;
}
.pagination-button.--disabled {
    background-color: var(--color-white);
    color: var(--color-grey);
    cursor: not-allowed;
}
.pagination-button span {
    display: inline-block;
    width: 100%;
    text-align: center;
}
.pagination-button span:hover {
    text-decoration: none;
}
</style>
