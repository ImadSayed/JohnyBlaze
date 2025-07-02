<script setup>
defineProps({
    progress: {
        type: Number,
        required: true,
    },
    uploading: {
        type: Boolean,
        required: true,
    },
});
</script>

<template>
    <div class="progress-bar" :class="{ show: uploading == true }">
        <p>Uploaded {{ progress }}%</p>
        <progress
            class="progress-bar progress-bar-info progress-bar-striped"
            :value="progress"
            max="100"
        ></progress>
    </div>
</template>

<style scoped>
div.progress-bar {
    display: none;
}
div.progress-bar.show {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 2rem 1rem;
    border: 2px solid var(--color-grey);
    border-radius: 0.5rem;
    box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.8);
    background-color: var(--color-white);
}
div.progress-bar.show p {
    margin-bottom: 0.5rem;
    font-weight: 600;
}
div.progress-bar.show progress {
    border: 1px solid var(--color-black);
    color: var(--color-green);
}
</style>
