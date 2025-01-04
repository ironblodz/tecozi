<template>
    <nav
        class="navbar fixed top-0 left-0 w-full bg-primary-default bg-opacity-90 z-30 p-4 flex justify-between items-center">
        <!-- Logo à esquerda -->
        <a href="/"><img :src="logo" alt="Logo" class="h-10 xl:h-14 mx-4 xl:mx-14 mt-3" /></a>

        <!-- Botão de menu para mobile/tablet -->
        <button @click="toggleMenu" class="lg:hidden text-white focus:outline-none mr-4">
            <svg v-if="!menuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Lista de navegação centralizada -->
        <ul v-if="menuOpen || screenIsLarge"
            class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-8 lg:ml-44 lg:items-center lg:justify-center"
            :class="{ 'absolute bg-primary-default top-20 left-0 w-full p-8 lg:p-0 lg:bg-transparent lg:static': !screenIsLarge }">
            <li><a href="/about"
                    class="text-white text-base xl:text-lg hover:bg-gray-500 hover:pt-[40px] hover:pb-[39px] hover:px-1">Sobre
                    Nós</a></li>
            <li><a href="/services"
                    class="text-white text-base xl:text-lg hover:bg-gray-500 hover:pt-[40px] hover:pb-[39px] hover:px-1">Serviços</a>
            </li>
            <li><a href="/materials"
                    class="text-white text-base xl:text-lg hover:bg-gray-500 hover:pt-[40px] hover:pb-[39px] hover:px-1">Materiais</a>
            </li>
            <li><a href="/portfolio"
                    class="text-white text-base xl:text-lg hover:bg-gray-500 hover:pt-[40px] hover:pb-[39px] hover:px-1">Portfólio</a>
            </li>

            <!-- Dropdown de Idioma -->
            <li class="relative px-12">
                <!-- Botão com o idioma selecionado -->
                <button @click="toggleLanguageMenu" class="flex items-center space-x-2">
                    <svg width="40" height="40" class="h-6 w-6 transition-transform duration-200" viewBox="0 0 40 40"
                        fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect width="40" height="40" fill="url(#pattern0_570_664)" />
                        <defs>
                            <pattern id="pattern0_570_664" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_570_664" transform="scale(0.0111111)" />
                            </pattern>
                            <image id="image0_570_664" width="90" height="90"
                                xlink:href="data:image/png;base64,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" />
                        </defs>
                    </svg>
                    <p :class="{ 'text-secondary-default': languageMenuOpen, 'text-white': !languageMenuOpen }"
                        class=" text-base xl:text-lg">
                        {{ currentLanguage }}
                    </p>
                    <svg :class="{ 'transform rotate-180': languageMenuOpen }" xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 transition-transform duration-200" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown -->
                <transition name="fade">
                    <div v-if="languageMenuOpen" ref="languageDropdown"
                        class="absolute bg-primary-default text-white shadow-lg rounded-lg mt-2 p-2 z-40 w-40">
                        <ul class="space-y-2">
                            <li @click="setLanguage('PT')"
                                class="flex items-center text-base space-x-2 cursor-pointer hover:bg-secondary-default p-2 rounded">
                                <img :src="ptFlag" alt="Portuguese" class="w-6" />
                                <span class="text-base xl:text-lg">Português</span>
                            </li>
                            <li @click="setLanguage('FR')"
                                class="flex items-center text-base space-x-2 cursor-pointer hover:bg-secondary-default p-2 rounded">
                                <img :src="frFlag" alt="French" class="w-6" />
                                <span class="text-base xl:text-lg">Français</span>
                            </li>
                            <li @click="setLanguage('EN')"
                                class="flex items-center text-base space-x-2 cursor-pointer hover:bg-secondary-default p-2 rounded">
                                <img :src="enFlag" alt="English" class="w-6" />
                                <span class="text-base xl:text-lg">English</span>
                            </li>
                        </ul>
                    </div>
                </transition>
            </li>
        </ul>

        <!-- Botão à direita -->
        <div v-if="screenIsLarge || menuOpen" class="mt-4 lg:mt-0">
            <button class="bg-secondary-default rounded-full py-2 px-6 text-white text-lg hover:bg-secondary-light">
                <a href="/contacts">Contactos</a>
            </button>
        </div>
    </nav>
</template>

<script>
import logo from '@/assets/images/logo/logotipo.svg';
import ptFlag from '@/assets/images/footer/icons8-portugal-48.png';
import frFlag from '@/assets/images/footer/icons8-france-48.png';
import enFlag from '@/assets/images/footer/icons8-usa-48.png';

export default {
    name: 'Navbar',
    data() {
        return {
            logo,
            ptFlag,
            frFlag,
            enFlag,
            menuOpen: false,
            screenIsLarge: window.innerWidth >= 1024,
            currentLanguage: this.getCurrentLanguage(),
            languageMenuOpen: false,
        };
    },
    methods: {
        toggleMenu() {
            this.menuOpen = !this.menuOpen;
        },
        handleResize() {
            this.screenIsLarge = window.innerWidth >= 1024;
            if (this.screenIsLarge) {
                this.menuOpen = false;
            }
        },
        toggleLanguageMenu() {
            this.languageMenuOpen = !this.languageMenuOpen;
        },
        setLanguage(language) {
            if (language === 'PT') {
                this.currentLanguage = 'Português';
                this.$i18n.locale = 'pt';
            } else if (language === 'FR') {
                this.currentLanguage = 'Français';
                this.$i18n.locale = 'fr';
            } else {
                this.currentLanguage = 'English';
                this.$i18n.locale = 'en';
            }
            this.languageMenuOpen = false;
        },
        getCurrentLanguage() {
            // Retorne o idioma atual conforme a configuração do i18n
            const currentLang = this.$i18n.locale;
            if (currentLang === 'pt') {
                return 'Português';
            } else if (currentLang === 'fr') {
                return 'Français';
            } else {
                return 'English';
            }
        },
    },
    mounted() {
        window.addEventListener('resize', this.handleResize);
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.handleResize);
    },
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.text-red-500 {
    color: red;
}
</style>
