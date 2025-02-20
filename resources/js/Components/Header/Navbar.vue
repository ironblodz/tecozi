<template>
    <component :is="currentNavbar" />
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue';
import MobileNavbar from '@/Components/Header/MobileNavbar.vue';
import DesktopNavbar from '@/Components/Header/DesktopNavbar.vue';


export default {
    components: {
        MobileNavbar,
        DesktopNavbar,
    },
    setup() {
        const currentNavbar = ref(window.innerWidth < 1024 ? 'MobileNavbar' : 'DesktopNavbar');

        const updateNavbar = () => {
            currentNavbar.value = window.innerWidth < 1024 ? 'MobileNavbar' : 'DesktopNavbar';
        };

        onMounted(() => {
            window.addEventListener('resize', updateNavbar);
        });

        onUnmounted(() => {
            window.removeEventListener('resize', updateNavbar);
        });

        return { currentNavbar };
    },
};
</script>
