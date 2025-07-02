<script setup>
console.log("posts-index page");
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PostsList from "@/Components/PostsList.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import Button from "@/Components/Button.vue";
const { props } = usePage();
const posts = ref(props.posts);
const isAdmin = ref(props.isAdmin || false);
const canDownload = !!props.auth.user;
const canDelete = isAdmin;
const canEdit = isAdmin;
/*console was showing warning as without bools, an object was being passed when a boolean is expected*/
</script>
<template>
    <!-- <title>JohnyBurnz - Posts</title> -->
    <Head title="Posts" />

    <AuthenticatedLayout v-if="props.auth.user && isAdmin">
        <div class="options-wrapper">
            <Button
                v-bind:type="'success'"
                v-bind:label="'Create Post'"
                v-bind:route="'posts.create'"
            ></Button>
        </div>
        <!-- @if (session('message'))
        <div class="alert alert-info">
            {{ session("message") }}
        </div>
        @endif -->

        <PostsList
            v-bind:posts="posts"
            v-bind:canDelete="canDelete"
            v-bind:canEdit="canEdit"
            v-bind:canDownload="canDownload"
        ></PostsList>
    </AuthenticatedLayout>

    <GuestLayout v-else>
        <PostsList
            v-bind:posts="posts"
            v-bind:canDownload="canDownload"
        ></PostsList>
    </GuestLayout>
</template>

<style scoped>
.options-wrapper {
    display: flex;
    justify-content: flex-end;
    padding: 1rem 5rem 0;
}
</style>
