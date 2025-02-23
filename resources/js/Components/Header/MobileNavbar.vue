<template>
    <nav class="fixed top-0 left-0 w-full bg-opacity-90 z-20 p-4 flex justify-between items-center transition-all duration-300"
        :class="isHome ? 'bg-primary-default' : 'bg-gray-200'">

        <!-- Logo -->
        <a href="/">
            <img :src="isHome ? logo : logoOther" alt="Logo" class="h-10 xl:h-14 mx-4 xl:mx-14 mt-3 transition-transform duration-300 hover:scale-110" />
        </a>

        <!-- Botão Mobile -->
        <button @click="toggleMenu" class="lg:hidden focus:outline-none mr-4 relative z-50 text-primary-default">
            <div class="hamburger" :class="{ 'open': menuOpen }">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>

        <!-- Menu Mobile -->
        <transition name="slide-fade">
            <div v-if="menuOpen" class="absolute top-0 left-0 w-full h-screen bg-black bg-opacity-90 flex flex-col items-center justify-center space-y-6 z-40 text-white">
                <ul class="text-center text-2xl space-y-6">
                    <li><a href="/about" @click="toggleMenu">Sobre Nós</a></li>
                    <li><a href="/services" @click="toggleMenu">Serviços</a></li>
                    <li><a href="/materials" @click="toggleMenu">Materiais</a></li>
                    <li><a href="/portfolio" @click="toggleMenu">Portfólio</a></li>
                </ul>
                <button class="bg-secondary-default text-white px-6 py-3 rounded-full text-lg hover:bg-secondary-light" @click="toggleMenu">
                    <a href="/contacts">Contactos</a>
                </button>
            </div>
        </transition>
    </nav>
</template>

<script>
import logo from '@/assets/images/logo/logotipo.svg';
import logoOther from '@/assets/images/logo/LOGO.svg';

export default {
    data() {
        return {
            logo,
            logoOther,
            menuOpen: false,
        };
    },
    computed: {
        isHome() {
            return window.location.pathname === '/';
        },
    },
    methods: {
        toggleMenu() {
            this.menuOpen = !this.menuOpen;
            document.body.classList.toggle('overflow-hidden', this.menuOpen);
        }
    },
};
</script>

<style scoped>
.hamburger {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 30px;
    height: 24px;
}
.hamburger span {
    display: block;
    height: 4px;
    width: 100%;
    background: #BF0404;
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}
.hamburger.open span:nth-child(1) {
    transform: translateY(10px) rotate(45deg);
}
.hamburger.open span:nth-child(2) {
    opacity: 0;
}
.hamburger.open span:nth-child(3) {
    transform: translateY(-10px) rotate(-45deg);
}
.slide-fade-enter-active, .slide-fade-leave-active {
    transition: all 0.3s ease-in-out;
}
.slide-fade-enter, .slide-fade-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}
</style>
