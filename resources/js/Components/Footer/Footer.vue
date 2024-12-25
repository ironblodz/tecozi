<template>
    <footer class="footer flex flex-col md:flex-row items-center md:items-start justify-center bg-primary-default border-b-4 border-secondary-default z-80 py-10 space-y-8 md:space-y-0 md:space-x-8">

      <!-- Logo -->
      <aside class="flex flex-col items-center md:items-start justify-center" aria-label="logo">
        <img :src="logo" alt="logo" class="mt-4 md:mt-0 ml-20 md:ml-0 w-60">
      </aside>

      <!-- Contactos -->
      <nav class="flex flex-col items-center md:items-start" aria-label="contactos">
        <h6 class="text-lg text-center text-base xl:text-lg md:text-left font-bold text-white">Contactos</h6>
        <a class="text-white text-center text-base xl:text-lg md:text-left font-bold">Produção</a>
        <a class="text-white text-center text-base xl:text-lg md:text-left">+351 968 433 620</a>
        <a class="text-white text-center text-base xl:text-lg md:text-left">(chamada para rede móvel nacional)</a>
        <a class="text-white text-center text-base xl:text-lg md:text-left font-bold">Financeiro</a>
        <a class="text-white text-center text-base xl:text-lg md:text-left">+351 966 122 406</a>
        <a class="text-white text-center text-base xl:text-lg md:text-left">(chamada para rede móvel nacional)</a>
      </nav>

      <!-- Localização -->
      <nav class="flex flex-col items-center md:items-start" aria-label="localização">
        <h6 class="text-center text-base xl:text-lg md:text-left font-bold text-white">Localização</h6>
        <a class="text-white text-center text-base xl:text-lg md:text-left">
          Rua da Lagoinha, nº29 Milhariças,<br> 3100-046 Abiul
        </a>
        <h6 class="text-base xl:text-lg text-center md:text-left font-bold text-white mt-4">Termos e Condições</h6>
        <a class="text-white text-center md:text-left text-base xl:text-lg">Política de privacidade</a>
        <a class="text-white text-center md:text-left text-base xl:text-lg">Resolução de Litígios</a>
      </nav>

      <!-- Páginas -->
      <nav class="flex flex-col items-center md:items-start" aria-label="páginas">
        <h6 class="text-base xl:text-lg text-left md:text-left text-white font-bold">Páginas</h6>
        <a :href="route('about')" class="text-white text-base xl:text-lg text-center md:text-left hover:underline ">Sobre Nós</a>
        <a :href="route('services')" class="text-white text-base xl:text-lg text-center md:text-left hover:underline ">Serviços</a>
        <a :href="route('materials')" class="text-white text-base xl:text-lg text-center md:text-left hover:underline ">Materiais</a>
        <a :href="route('portfolio')" class="text-white text-base xl:text-lg text-center md:text-left hover:underline ">Portfólio</a>
        <a :href="route('contacts')" class="text-white text-base xl:text-lg text-center md:text-left hover:underline ">Contactos</a>
      </nav>

      <!-- Kitchen Image -->
      <aside class="flex justify-center md:justify-start">
        <img :src="kitchen" alt="kitchen" class="w-48 sm:w-64 lg:w-72 transform -scale-x-100">
      </aside>
    </footer>
  </template>


  <script>
  import logo from "@/assets/images/logo/logotipo.svg";
  import kitchen from "@/assets/images/footer/wallpaperfooter.svg";

  export default {
    name: "Footer",
    data() {
      return {
        logo,
        kitchen,
      };
    },
  };
  </script>
