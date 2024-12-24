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
            <li>
                <a href="/about" class="text-white text-lg hover:text-gray-400">Sobre Nós</a>
            </li>
            <li>
                <a href="/services" class="text-white text-lg hover:text-gray-400">Serviços</a>
            </li>
            <li>
                <a href="/materials" class="text-white text-lg hover:text-gray-400">Materiais</a>
            </li>
            <li>
                <a href="/portfolio" class="text-white text-lg hover:text-gray-400">Portfólio</a>
            </li>
            <li @click="toggleLanguage" class="cursor-pointer">
                <div class="flex flex-row justify-center items-center">
                    <img :src="geography" alt="geography" class="w-6">
                    <p class="text-lg text-red-700 font-medium">{{ currentLanguage }}</p>
                </div>
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
import geography from '@/assets/images/home/Geography.svg';

export default {
  name: 'Navbar',
  data() {
    return {
      logo,
      geography,
      menuOpen: false,
      screenIsLarge: window.innerWidth >= 1024,
      currentLanguage: 'PT',
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
    toggleLanguage() {
  // Alternar idioma
  if (this.currentLanguage === 'PT') {
    this.currentLanguage = 'FR';
    this.$i18n.locale = 'fr';
  } else if (this.currentLanguage === 'FR') {
    this.currentLanguage = 'EN';
    this.$i18n.locale = 'en';
  } else {
    this.currentLanguage = 'PT';
    this.$i18n.locale = 'pt';
  }
}
  },
  mounted() {
    window.addEventListener('resize', this.handleResize);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.handleResize);
  }
};

</script>

<style scoped>
/* Adicione estilos específicos para o menu, se necessário */
</style>
