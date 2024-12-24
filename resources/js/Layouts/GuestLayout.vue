<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-primary-default">
        <div class="absolute bottom-0 left-2">
            <img :src="wallpaperkitchen" class="w-72 xl:w-96 h-full object-cover" alt="kitchen">
        </div>
        <div class="w-full sm:max-w-md xl:max-w-xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-5 flex justify-center">
                <Link href="/">
                    <img :src="logo" alt="logo" class="w-52 object-cover object-center ml-20">
                </Link>
            </div>
            <slot />
        </div>
    </div>
</template>

<script>
import logo from '@/assets/images/home/LOGO.png';
import wallpaperkitchen from '@/assets/images/home/wallpaper.svg';
export default {
    data() {
        return {
            logo,
            wallpaperkitchen
        };
    },
}
</script>
