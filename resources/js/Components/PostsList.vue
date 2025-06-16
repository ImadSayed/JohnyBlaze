<script setup>
import PostCard from "@/Components/PostCard.vue";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";

const props = defineProps({
    posts: {
        type: Object,
        required: true,
    },
    canDelete: {
        type: Boolean,
        default: false,
    },
    canEdit: {
        type: Boolean,
        default: false,
    },
    canDownload: {
        type: Boolean,
        default: false,
    },
});

let deletePost = ref(false);
let deletePostId = ref(0);

const confirmDeletePost = (id) => {
    window.location.href = route("posts.destroy", id);
};
const cancelDelete = () => {
    console.log("Cancel delete post");
    deletePost.value = false;
    deletePostId.value = 0;
};

let editPostId = ref(0);
let editPost = ref(false);
const confirmEditPost = (id) => {
    console.log("Edit post with ID: " + id);
    window.location.href = route("posts.edit", id);
};
const cancelEdit = () => {
    console.log("Cancel edit post");
    editPost.value = false;
    editPostId.value = 0;
};
</script>
<template>
    <div class="posts-wrapper">
        <div class="posts-body">
            <div class="list-wrapper">
                <ul>
                    <li v-for="post in posts.data" :key="post.id">
                        <PostCard
                            v-bind:post="post"
                            v-bind:canDelete="canDelete"
                            v-bind:canDownload="canDownload"
                            @delete-post="
                                (id) => {
                                    console.log('Delete post with ID:' + id);
                                    deletePostId = id;
                                    deletePost = true;
                                }
                            "
                            v-bind:canEdit="canEdit"
                            @edit-post="
                                (id) => {
                                    console.log('Edit post with ID:' + id);
                                    editPostId = id;
                                    editPost = true;
                                }
                            "
                        ></PostCard>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="delete-post-confirmation"
            :class="{ show: deletePost == true }"
        >
            <p>Are you sure you want to delete this post?</p>
            <button
                class="btn btn-danger confirm-button"
                @click="confirmDeletePost(deletePostId)"
            >
                Delete
            </button>
            <button class="btn btn-info cancel-button" @click="cancelDelete()">
                Cancel
            </button>
        </div>

        <div class="edit-post-confirmation" :class="{ show: editPost == true }">
            <p>Are you sure you want to edit this post?</p>
            <button
                class="btn btn-primary"
                @click="confirmEditPost(editPostId)"
            >
                Edit
            </button>
            <button class="btn btn-info" @click="cancelEdit()">Cancel</button>
        </div>

        <Pagination v-bind:data="posts"></Pagination>
    </div>
</template>

<style scoped>
.posts-wrapper {
    padding: 1rem 3rem 3rem;
}
.posts-body {
    padding: 0 2rem;
}
.list-wrapper {
    border-radius: 0.5rem;
    padding: 1.5rem;
    background-color: var(--color-white);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}
.list-wrapper ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}
.delete-post-confirmation {
    display: none;
}
.delete-post-confirmation.show {
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: var(--color-white);
    border: 2px solid var(--color-red);
    box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.8);
    padding: 1rem;
    border-radius: 0.5rem;
    z-index: 1000;
}
.delete-post-confirmation.show p {
    margin-bottom: 1rem;
    font-size: 1rem;
    color: var(--color-black);
}

.delete-post-confirmation.show .btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
}
.edit-post-confirmation.show .btn:first-of-type,
.delete-post-confirmation.show .btn:first-of-type {
    margin-bottom: 0.5rem;
}
.delete-post-confirmation.show .btn-danger {
    background-color: #dc3545; /* Bootstrap danger color */
    color: white;
}
.delete-post-confirmation.show .btn-danger:hover {
    background-color: #8f0e1a; /* Darker red on hover */
}

.delete-post-confirmation.show .btn-info {
    background-color: var(--color-grey); /* Bootstrap info color */
    color: white;
}
.delete-post-confirmation.show .btn-info:hover {
    background-color: var(--color-dark); /* Darker grey on hover */
}
.edit-post-confirmation {
    display: none;
}
.edit-post-confirmation.show {
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: var(--color-white);
    border: 2px solid var(--color-blue);
    box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.8);
    padding: 1rem;
    border-radius: 0.5rem;
    z-index: 1000;
}
.edit-post-confirmation.show p {
    margin-bottom: 1rem;
    font-size: 1rem;
    color: var(--color-black);
}
.edit-post-confirmation.show .btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
}
.edit-post-confirmation.show .btn-primary {
    background-color: #007bff; /* Bootstrap primary color */
    color: white;
}
.edit-post-confirmation.show .btn-primary:hover {
    background-color: #0056b3; /* Darker blue on hover */
}
.edit-post-confirmation.show .btn-info {
    background-color: var(--color-grey); /* Bootstrap info color */
    color: white;
}
.edit-post-confirmation.show .btn-info:hover {
    background-color: var(--color-dark); /* Darker grey on hover */
}
</style>
