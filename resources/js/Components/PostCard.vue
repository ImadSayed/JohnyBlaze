<script setup>
defineProps({
    post: {
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
        required: true,
    },
});
function getFileNameFromPath($path) {
    return $path.substring($path.lastIndexOf("/") + 1);
}
</script>

<template>
    <div class="post-card-wrapper">
        <div class="post-card">
            <div class="post-media-wrapper">
                <video
                    class="post-media"
                    controls
                    :poster="post.image"
                    width="320"
                    height="240"
                    subtitle="Music Video"
                    aria-describedby="Music Video"
                >
                    <source :src="post.media" :type="post.media_type" />
                    <source
                        v-if="post.media_type == '.3gp'"
                        :src="post.media.replace('.3gp', '.mp4')"
                        :type="'video/mp4'"
                    />
                    <source
                        v-if="post.media_type == '.3gp'"
                        :src="post.media.replace('.3gp', '.webm')"
                        :type="'video/webm'"
                    />
                    Your browser does not support the video tag.
                </video>
            </div>
            <h3 class="post-title">
                <a>{{ post.caption }}</a>
            </h3>
            <div class="download" v-if="canDownload">
                <a
                    :href="post.media"
                    class="download-link"
                    :download="getFileNameFromPath(post.media)"
                    >Download</a
                >
            </div>
            <div
                class="delete"
                v-if="canDelete"
                v-on:click="$emit('delete-post', post.id)"
            ></div>
            <div
                class="edit"
                v-if="canEdit"
                v-on:click="$emit('edit-post', post.id)"
            ></div>
        </div>
    </div>
</template>

<style scoped>
.post-card-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 4px;
    max-width: 300px;
}
.post-card {
    align-self: center;
    display: flex;
    flex-direction: column;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border: 2px solid #ccc;
    position: relative;
}
.post-media-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 220px;
    overflow: hidden;
    border-radius: 8px 8px 0 0;
    width: 100%;
}
.post-media {
    border-radius: 8px 8px 0 0;
    object-fit: cover;
    background-color: var(--color-black); /* Fallback for unsupported media */
    color: var(--color-white);
    max-width: 100%;
    height: 100%;
}
.post-title {
    align-self: center;
    font-size: 20px;
    text-align: center;
    width: 100%;
    padding: 5px 10px;
    border-top: 2px solid #ccc;
}
div.delete {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    width: 24px;
    height: 24px;
    background-color: var(--color-red);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}
div.delete::after {
    content: "X";
    font-size: 12px;
    font-weight: bold;
    color: var(--color-white);
}
div.edit {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    width: 24px;
    height: 24px;
    background-color: var(--color-blue);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}
div.edit::after {
    content: "✎";
    font-size: 12px;
    font-weight: bold;
    color: var(--color-white);
}
div.download {
    display: flex;
    flex-direction: row;
    justify-content: center;
    margin: 0.5rem 0;
}
div.download a.download-link {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
    text-decoration: none;
    font-weight: bold;
    background-color: #007bff; /* Bootstrap primary color */
    color: white;
}
div.download a.download-link:hover {
    background-color: #0056b3;
}
</style>
