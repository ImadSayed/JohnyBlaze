<script setup>
import { usePage, Head } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Link } from "@inertiajs/vue3";
import Button from "@/Components/Button.vue";

const { props } = usePage();
const users = ref(props.users || []);
const levels = ref(props.userLevels || []);
const isAdmin = ref(props.isAdmin || false);

let deleteUser = ref(false);
let deleteUserId = ref(0);
let deleteUserName = ref("");

const confirmUserDelete = (user) => {
    deleteUserId.value = user.id;
    deleteUserName.value = user.name;
    deleteUser.value = true;
};
const cancelDelete = () => {
    deleteUser.value = false;
    deleteUserId.value = 0;
    deleteUserName.value = "";
};
</script>

<template>
    <Head title="JohnyBurnz - Users" />
    <AuthenticatedLayout v-if="props.auth.user && isAdmin">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Users
            </h2>
        </template>

        <div class="options-wrapper">
            <p v-if="users.data.length == 0">
                No users found. Please create a user.
            </p>
            <p v-else>
                {{ users.data.length }}
                {{ users.data.length == 1 ? "user" : "users" }} found.
            </p>
        </div>

        <div class="users-wrapper">
            <div class="users-table">
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th class="level">Level</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users.data" :key="user.id">
                            <td class="name">{{ user.name }}</td>
                            <td class="email">{{ user.email }}</td>
                            <td class="level">
                                {{ levels[user.level_id] }}
                            </td>
                            <td>
                                <Button
                                    v-bind:type="'primary'"
                                    v-bind:label="'Edit'"
                                    v-bind:route="'users.edit'"
                                    v-bind:id="user.id"
                                ></Button>
                            </td>
                            <td>
                                <button
                                    class="btn btn-danger delete-btn"
                                    v-on:click="confirmUserDelete(user)"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div
            id="confirmationBox"
            class="delete-confirmation"
            :class="{ show: deleteUser == true }"
        >
            <p>
                Are you sure you want to delete
                {{ deleteUserName }}?
            </p>
            <Button
                v-bind:type="'danger'"
                v-bind:label="'Delete'"
                v-bind:route="'users.destroy'"
                v-bind:id="userToDelete"
            ></Button>
            <button
                class="btn btn-info cancel-delete"
                v-on:click="cancelDelete"
            >
                Cancel
            </button>
        </div>
    </AuthenticatedLayout>
    <GuestLayout v-else></GuestLayout>
</template>

<style scoped>
.options-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    padding: 1rem 5rem 0;
}
.options-wrapper p {
    margin: 0;
    font-size: 1rem;
    color: #333;
    border: 2px solid var(--color-dark);
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    font-weight: bold;
}
.users-wrapper {
    padding: 1rem 5rem;
}
.users-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    background-color: var(--color-white);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 0.5rem;
    overflow: hidden;
    padding: 1rem;
}
.user-table {
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 0.25rem;
}
.user-table th,
.user-table td {
    padding: 0.5rem;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
.user-table th {
    background-color: #f2f2f2;
}
.user-table tr:hover {
    background-color: #a1a1a1;
}
.user-table a.edit {
    color: #007bff;
    text-decoration: none;
}
.user-table tr:hover a.edit {
    color: #1900fd;
}
.user-table a.edit:hover {
    text-decoration: underline;
}
.user-table a.delete {
    color: #dc3545;
    text-decoration: none;
}
.user-table tr:hover a.delete {
    color: #f50019;
}
.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
    text-decoration: none;
    font-weight: bold;
}
.btn-danger {
    background-color: #dc3545; /* Bootstrap danger color */
    color: white;
}
.btn-danger:hover {
    background-color: #8f0e1a; /* Darker grey on hover */
}
.user-table a {
    cursor: pointer;
}
.delete-confirmation {
    display: none;
}
.delete-confirmation.show {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    background-color: var(--color-white);
    border: 2px solid var(--color-grey);
    box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.8);
    padding: 1rem;
}
.delete-confirmation.show p {
    font-weight: bold;
    margin-bottom: 0.5rem;
}
.delete-confirmation.show > a {
    text-align: center;
}
.delete-confirmation.show button {
    margin-top: 0.5rem;
    text-align: center;
    background-color: var(--color-grey);
    color: var(--color-white);
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
    text-decoration: none;
    font-weight: bold;
}
.delete-confirmation.show button:hover {
    background-color: var(--color-dark);
}
</style>
