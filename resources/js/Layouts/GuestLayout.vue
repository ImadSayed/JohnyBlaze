<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

const props = defineProps({
    canLogin: {
        type: Boolean,
        default: true,
    },
    canRegister: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <div class="guest-nav">
        <nav>
            <ul class="nav-options">
                <li>
                    <Link href="/">Home</Link>
                </li>
                <li>
                    <Link href="/posts">View Posts</Link>
                </li>
            </ul>

            <div
                v-if="$page.props.auth.user"
                class="sm:ms-6 sm:flex sm:items-center"
            >
                <!-- Settings Dropdown -->
                <div class="relative ms-3">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                >
                                    {{ $page.props.auth.user.name }}

                                    <svg
                                        class="-me-0.5 ms-2 h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('profile.edit')">
                                Profile
                            </DropdownLink>
                            <DropdownLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>

            <ul v-else class="nav-auth">
                <li v-if="canLogin">
                    <Link href="/login">Login</Link>
                </li>
                <li v-if="canRegister">
                    <Link href="/register">Register</Link>
                </li>
            </ul>
        </nav>
    </div>
    <div class="guest-slot">
        <slot />
    </div>
</template>

<style scoped>
.guest-nav {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: var(--color-gray-100);
    padding: 0 2rem;
    border-bottom: 1px solid var(--color-gray-200);
    height: 4rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}
.guest-nav nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    padding: 0;
}

.nav-options,
.nav-auth {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    gap: 1rem;
}

.nav-auth li {
    margin: 0 0 0 1rem;
}
.nav-options li {
    margin: 0 1rem 0 0;
    align-self: center;
}
@media all and (min-width: 395px) {
    .guest-nav nav {
        padding: 0;
    }
}
@media all and (min-width: 415px) {
    .guest-nav nav {
        padding: 0 1rem;
    }
}
@media all and (min-width: 550px) {
    .guest-nav nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 0 5rem;
    }
}
</style>

<style>
.guest-slot > form {
    max-width: 60%;
    margin: 3rem auto 0;
}
@media all and (min-width: 550px) {
    .guest-slot > form {
        max-width: 50%;
    }
}
@media all and (min-width: 768px) {
    .guest-slot > form {
        max-width: 40%;
    }
}
@media all and (min-width: 900px) {
    .guest-slot > form {
        max-width: 30%;
    }
}
</style>
