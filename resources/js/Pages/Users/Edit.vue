<script setup>
import { useForm, usePage, Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Button from "@/Components/Button.vue";
const { props } = usePage();
const user = props.user;
const levels = props.userLevels;
const isAdmin = props.isAdmin || false;
const form = useForm({
    user_id: user.data.id,
    level_id: user.data.level_id,
});
if (!isAdmin) {
    window.location.href = route("users.index");
}
</script>

<template>
    <Head title="JohnyBurnz - Edit" />
    <AuthenticatedLayout v-if="props.auth.user && isAdmin">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit User
            </h2>
        </template>

        <div class="user-edit">
            <form @submit.prevent="form.post(route('users.update', form))">
                <div>
                    <label for="name">Name:</label>
                    <input
                        type="text"
                        id="name"
                        :value="user.data.name"
                        readonly
                    />
                </div>

                <div>
                    <label for="email">Email:</label>
                    <input
                        type="text"
                        id="email"
                        :value="user.data.email"
                        readonly
                    />
                </div>

                <div>
                    <label for="level">Level:</label>
                    <select name="level" id="level" v-model="form.level_id">
                        <option
                            v-for="(value, name, index) in levels"
                            :value="name"
                            :key="index"
                        >
                            {{ value }}
                        </option>
                    </select>
                </div>

                <button
                    type="submit"
                    class="btn btn-primary"
                    v-on:click="form.post(route('users.update', form))"
                >
                    Update
                </button>

                <Button
                    v-bind:type="'info'"
                    v-bind:label="'Back'"
                    v-bind:route="'users.index'"
                >
                </Button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.user-edit {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.user-edit form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    padding-top: 4rem;
}
.user-edit form > div {
    display: flex;
    margin-bottom: 1rem;
    align-items: center;
}
.user-edit form > div label {
    min-width: 4rem;
    display: flex;
}
.user-edit form > div :not(label) {
    border-radius: 0.25rem;
}
.user-edit form > a {
    align-self: center;
    width: 100%;
    text-align: center;
}
.user-edit form > a {
    margin-top: 0.5rem;
}

button.btn {
    background-color: #007bff; /* Bootstrap primary color */
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
    width: 100%;
}
button.btn:hover {
    background-color: #0056b3; /* Darker blue on hover */
}
.btn-primary {
    background-color: #007bff; /* Bootstrap primary color */
    color: white;
}
.btn-primary:hover {
    background-color: #004ea1; /* Darker blue on hover */
}
</style>
