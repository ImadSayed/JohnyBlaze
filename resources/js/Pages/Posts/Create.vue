<script setup>
import { useForm, Head } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import ProgressBar from "@/Components/ProgressBar.vue";

document.title = "Create Post";
const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    userId: props.user.data.id,
    caption: "",
    image: "",
    media: "",
});

let uploading = ref(false);
let progress = ref(0);
let message = ref("");

const uploadForm = async () => {
    uploading.value = true;
    const formData = new FormData();
    formData.append("userId", form.userId);
    formData.append("caption", form.caption);
    if (form.image) {
        formData.append("image", form.image);
    }
    if (form.media) {
        formData.append("media", form.media);
    }
    try {
        await axios.post("/upload", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
            onUploadProgress: (progressEvent) => {
                progress.value = Math.round(
                    (progressEvent.loaded * 100) / progressEvent.total
                );
            },
        });
        message.value = "Success";
        window.location.href = "/posts";
    } catch (error) {
        console.log("Error: " + error);
        message.value = "Failed to upload";
    } finally {
        uploading.value = false;
    }
};
</script>

<template>
    <Head title="JohnyBurnz - Create" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create Post
            </h2>
        </template>

        <div class="create-post-wrapper">
            <form @submit.prevent="uploadForm">
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
                    <label for="image">Image URL</label>
                    <input
                        type="file"
                        id="image"
                        v-on:change="form.image = $event.target.files[0]"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.image }"
                    />
                    <InputError :message="form.errors.image" class="mt-2" />
                </div>
                <div class="form-group">
                    <label for="media">Media</label>
                    <input
                        type="file"
                        id="media"
                        v-on:change="form.media = $event.target.files[0]"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.media }"
                    />
                    <InputError :message="form.errors.media" class="mt-2" />
                </div>
                <div class="form-group">
                    <button
                        type="submit"
                        class="btn btn-primary"
                        v-on:click="uploadForm"
                        :disabled="uploading"
                    >
                        Create Post
                    </button>
                </div>
            </form>
            <div class="back-button">
                <a :href="route('posts.index')" class="btn btn-info">
                    Back to Posts
                </a>
            </div>
            <ProgressBar
                :progress="progress"
                :uploading="uploading"
            ></ProgressBar>
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
.create-post-wrapper {
    max-width: 600px;
    margin: 1rem auto 0;
    padding: 2rem;
    background-color: #f8f9fa; /* Light background */
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    position: relative;
}
.create-post-wrapper h2 {
    margin-bottom: 1rem;
    text-align: center;
}
.create-post-wrapper form {
    display: flex;
    flex-direction: column;
}
.create-post-wrapper .form-group {
    margin-bottom: 1rem;
}
.create-post-wrapper .form-control {
    padding: 0.5rem;
    border: 1px solid #ced4da; /* Bootstrap border color */
    border-radius: 0.25rem;
}
.create-post-wrapper .btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
}
.create-post-wrapper .btn-primary {
    background-color: #007bff; /* Bootstrap primary color */
    color: white;
}
.create-post-wrapper .btn-primary:hover {
    background-color: #0056b3; /* Darker blue on hover */
}
.create-post-wrapper .btn-success {
    background-color: #28a745; /* Bootstrap success color */
    color: white;
}
.create-post-wrapper .btn-success:hover {
    background-color: #218838; /* Darker green on hover */
}
.create-post-wrapper .btn-danger {
    background-color: #dc3545; /* Bootstrap danger color */
    color: white;
}
.create-post-wrapper .btn-danger:hover {
    background-color: #c82333; /* Darker red on hover */
}
.create-post-wrapper .btn-warning {
    background-color: #ffc107; /* Bootstrap warning color */
    color: black;
}
.create-post-wrapper .btn-warning:hover {
    background-color: #e0a800; /* Darker yellow on hover */
}
.create-post-wrapper .btn-info {
    background-color: var(--color-grey); /* Bootstrap info color */
    color: white;
}
.create-post-wrapper .btn-info:hover {
    background-color: var(--color-yellow); /* Darker grey on hover */
}
.create-post-wrapper .back-button {
    margin-bottom: 1rem;
}
</style>
