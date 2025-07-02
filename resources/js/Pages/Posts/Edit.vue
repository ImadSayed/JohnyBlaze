<script setup>
import { useForm, Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";

document.title = "Create Post";
const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    post: {
        type: Array,
        required: true,
    },
});
let removeImage = false;

const form = useForm({
    id: props.post.id,
    userId: props.user.data.id,
    caption: props.post.caption || "",
    image: props.post.image,
    media: props.post.media || "",
    removeImage: removeImage,
});
</script>

<template>
    <Head title="JohnyBurnz - Edit" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Post
            </h2>
        </template>

        <div class="edit-post-wrapper">
            <form @submit.prevent="form.post(route('posts.update', form))">
                <div class="form-group">
                    <label for="caption">Caption</label>
                    <input
                        type="text"
                        id="caption"
                        v-model="form.caption"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.caption }"
                        placeholder="Enter caption"
                        required
                    />
                    <InputError :message="form.errors.caption" class="mt-2" />
                </div>
                <div class="form-group">
                    <label for="image"
                        >Image:
                        {{
                            form.image ? "image selected" : "no image selected"
                        }}
                    </label>
                    <input
                        type="file"
                        id="image"
                        v-on:change="form.image = $event.target.files[0]"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.image }"
                    />
                    <InputError :message="form.errors.image" class="mt-2" />
                    <div class="removeImage">
                        <label for="removeImageCheckbox">
                            Remove Image Cover
                        </label>
                        <input
                            id="removeImageCheckbox"
                            type="checkbox"
                            v-model="form.removeImage"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <button
                        type="submit"
                        class="btn btn-primary"
                        v-on:click="form.post(route('posts.update', form))"
                    >
                        Update
                    </button>
                </div>
            </form>
            <div class="back-button">
                <a :href="route('posts.index')" class="btn btn-info">
                    Back to Posts
                </a>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.form-group {
    margin-bottom: 1rem;
}
.form-control {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 0.25rem;
}
.btn {
    background-color: #007bff; /* Bootstrap primary color */
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
}
.btn:hover {
    background-color: #0056b3; /* Darker blue on hover */
}
.btn-primary {
    background-color: #007bff; /* Bootstrap primary color */
    color: white;
}
.btn-primary:hover {
    background-color: #0056b3; /* Darker blue on hover */
}
.edit-post-wrapper {
    max-width: 600px;
    margin: 1rem auto 0;
    padding: 2rem;
    background-color: #f8f9fa; /* Light background */
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}
.edit-post-wrapper h2 {
    margin-bottom: 1rem;
    text-align: center;
}
.edit-post-wrapper form {
    display: flex;
    flex-direction: column;
}
.edit-post-wrapper .form-group {
    margin-bottom: 1rem;
}
.edit-post-wrapper .form-control {
    padding: 0.5rem;
    border: 1px solid #ced4da; /* Bootstrap border color */
    border-radius: 0.25rem;
}
.edit-post-wrapper .btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
}
.edit-post-wrapper .btn-primary {
    background-color: #007bff; /* Bootstrap primary color */
    color: white;
}
.edit-post-wrapper .btn-primary:hover {
    background-color: #0056b3; /* Darker blue on hover */
}
.edit-post-wrapper .btn-info {
    background-color: var(--color-grey); /* Bootstrap info color */
    color: white;
}
.edit-post-wrapper .btn-info:hover {
    background-color: var(--color-dark); /* Darker grey on hover */
}
.edit-post-wrapper .back-button {
    margin-bottom: 1rem;
}
.edit-post-wrapper .removeImage {
    display: flex;
    flex-direction: row;
    align-items: center;
}
.edit-post-wrapper .removeImage #removeImageCheckbox {
    margin: 0.25rem 0 0 1rem;
    align-self: center;
}
</style>
