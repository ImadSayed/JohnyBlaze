<script setup>
import { Head, Link } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { usePage } from "@inertiajs/vue3";
const { props } = usePage();

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="JohnyBurnz" />
    <GuestLayout :canLogin="canLogin" :canRegister="canRegister"> </GuestLayout>
    <main class="homepage">
        <section class="container">
            <div class="image-container">
                <img
                    src="/media/jbOnGuitar.png"
                    alt="Johny Burnz on a guitar"
                    class="image"
                />
            </div>
            <div class="text-container">
                <h1><span>Name: </span>Johny Burnz</h1>
                <h3><span>TikTok Profile: </span>JohnyBurnz</h3>
                <p></p>
            </div>
        </section>
    </main>
</template>

<style scoped>
main.homepage {
    display: flex;
    width: 100%;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
}
main.homepage section.container {
    display: flex;
    flex-direction: row;
    width: 90%;
    justify-content: flex-start;
}
main.homepage section.container .image-container {
    margin-top: 2rem;
    display: flex;
    height: 80dvh;
    width: 40%;
}
main.homepage section.container .image-container img {
    display: block;
    margin: 0 auto;
}
main.homepage section.container .text-container {
    margin-top: 5rem;
    height: 80dvh;
    width: 60%;
    display: flex;
    flex-direction: column;
    align-items: center;
}
main.homepage section.container .text-container h1 {
    width: 100%;
    text-align: center;
    font-size: 2rem;
}
main.homepage section.container .text-container h1 > span {
    font-size: 1.5rem;
}
</style>
