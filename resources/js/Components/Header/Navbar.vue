<template>
    <nav class="navbar fixed top-0 left-0 w-full bg-primary-default bg-opacity-90 z-30 p-4 flex justify-between items-center">
      <!-- Logo à esquerda -->
      <a href="/"><img :src="logo" alt="Logo" class="h-10 xl:h-14 mx-4 xl:mx-14 mt-3" /></a>

      <!-- Botão de menu para mobile/tablet -->
      <button @click="toggleMenu" class="lg:hidden text-white focus:outline-none mr-4">
        <svg v-if="!menuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <!-- Lista de navegação centralizada -->
      <ul v-if="menuOpen || screenIsLarge"
          class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-8 lg:ml-44 lg:items-center lg:justify-center"
          :class="{ 'absolute bg-primary-default top-20 left-0 w-full p-8 lg:p-0 lg:bg-transparent lg:static': !screenIsLarge }">
        <li><a href="/about" class="text-white text-lg hover:text-gray-400">Sobre Nós</a></li>
        <li><a href="/services" class="text-white text-lg hover:text-gray-400">Serviços</a></li>
        <li><a href="/materials" class="text-white text-lg hover:text-gray-400">Materiais</a></li>
        <li><a href="/portfolio" class="text-white text-lg hover:text-gray-400">Portfólio</a></li>

        <!-- Dropdown de Idioma -->
        <li class="relative">
          <button @click="toggleLanguageMenu" class="flex items-center space-x-2 text-white text-lg">
            <img :src="getFlag(currentLanguage)" alt="geography" class="w-6" />
            <p class="text-red-700 font-medium">{{ currentLanguage }}</p>
          </button>
          <!-- Dropdown -->
          <div v-if="languageMenuOpen"
               class="absolute bg-white text-black shadow-lg rounded-lg mt-2 p-2 z-40 w-[72px]"
               @mouseover="openDropdown" @mouseleave="closeDropdown">
            <ul class="space-y-2">
              <li @click="setLanguage('PT')" class="flex items-center space-x-2 cursor-pointer">
                <img :src="ptFlag" alt="Portuguese" class="w-6" />
                <span class="text-lg">PT</span>
              </li>
              <li @click="setLanguage('FR')" class="flex items-center space-x-2 cursor-pointer">
                <img :src="frFlag" alt="French" class="w-6" />
                <span class="text-lg">FR</span>
              </li>
              <li @click="setLanguage('EN')" class="flex items-center space-x-2 cursor-pointer">
                <img :src="enFlag" alt="English" class="w-6" />
                <span class="text-lg">EN</span>
              </li>
            </ul>
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
  import ptFlag from '@/assets/images/footer/portugal_flags_flag_17054.png';
  import frFlag from '@/assets/images/footer/france_flags_flag_16999.png';
  import enFlag from '@/assets/images/footer/united_kingdom_flags_flag_17079.png';

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
        currentLanguage: 'PT',
        languageMenuOpen: false, // Para controlar a visibilidade do dropdown de idiomas
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
      openDropdown() {
        this.languageMenuOpen = true; // Manter o dropdown aberto quando passar o mouse
      },
      closeDropdown() {
        // Não fecha automaticamente aqui
      },
      setLanguage(language) {
        this.currentLanguage = language;
        this.languageMenuOpen = false; // Fecha o dropdown após seleção
        if (language === 'PT') {
          this.$i18n.locale = 'pt';
        } else if (language === 'FR') {
          this.$i18n.locale = 'fr';
        } else {
          this.$i18n.locale = 'en';
        }
      },
      getFlag(language) {
        switch (language) {
          case 'PT': return this.ptFlag;
          case 'FR': return this.frFlag;
          case 'EN': return this.enFlag;
          default: return this.ptFlag;
        }
      },
      handleClickOutside(event) {
        const languageDropdown = this.$refs.languageDropdown;
        if (languageDropdown && !languageDropdown.contains(event.target)) {
          this.languageMenuOpen = false;
        }
      }
    },
    mounted() {
      window.addEventListener('resize', this.handleResize);
      document.addEventListener('click', this.handleClickOutside); // Adicionando o ouvinte de evento global
    },
    beforeDestroy() {
      window.removeEventListener('resize', this.handleResize);
      document.removeEventListener('click', this.handleClickOutside); // Removendo o ouvinte de evento
    }
  };
  </script>

  <style scoped>
  /* Estilos para o dropdown */
  .navbar ul li {
    transition: all 0.3s ease;
  }

  .navbar ul li:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
  }

  .navbar ul li .text-lg {
    font-weight: 600;
  }

  .navbar ul li img {
    transition: transform 0.2s ease;
  }

  .navbar ul li img:hover {
    transform: scale(1.1);
  }

  .navbar ul li .text-red-700 {
    margin-left: 8px;
  }

  /* Estilos para o dropdown */
  .navbar li .absolute {
    display: none;
  }

  .navbar li:hover .absolute {
    display: block;
  }

  /* Dropdown aberto */
  .navbar li .absolute {
    display: block;
  }
  </style>
