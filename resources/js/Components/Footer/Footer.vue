<template>
    <footer
        class="footer flex flex-col xl:flex-row items-center justify-center bg-primary-default border-b-4 border-secondary-default z-80 py-10 xl:space-y-0 xl:space-x-8">

        <!-- Logo -->
        <aside class="flex flex-col items-center justify-center shrink-0" aria-label="logo">
            <img :src="logo" alt="logo" class="mt-4 xl:mt-0 mx-auto w-60">
        </aside>


        <!-- Contactos -->
        <nav class="flex flex-col items-center xl:items-start" aria-label="contactos">
            <a class="text-white text-center text-base xl:text-xl xl:text-left font-bold">Produção</a>
            <a class="text-white text-center text-base xl:text-left">+351 968 433 620</a>
            <a class="text-white text-center text-sm xl:text-left mb-2">(chamada para rede móvel nacional)</a>
            <a class="text-white text-center text-base xl:text-xl xl:text-left font-bold">Financeiro/ Orçamentação</a>
            <a class="text-white text-center text-base xl:text-left">+351 966 122 406</a>
            <a class="text-white text-center text-sm xl:text-left mb-2">(chamada para rede móvel nacional)</a>
            <a class="text-white text-center text-base xl:text-xl xl:text-left font-bold">Geral</a>
            <a class="text-white text-center text-base xl:text-left">+351 236 926 148</a>
            <a class="text-white text-center text-sm xl:text-left">(chamada para rede fixa nacional)</a>
        </nav>

        <!-- Localização -->
        <nav class="flex flex-col items-center xl:items-start" aria-label="localização">
            <div class="mb-5">
                <h6 class="text-center text-base xl:text-left xl:text-xl font-bold text-white mb-2">Localização</h6>
                <a class="text-white text-center text-base xl:text-left">
                    Rua da Lagoinha, nº29 Milhariças,<br> 3100-046 Abiul
                </a>
            </div>
            <h6 class="text-base text-center xl:text-left font-bold xl:text-xl text-white mt-4 mb-2">Termos e Condições</h6>
            <a :href="route('privacy')" class="text-white text-center xl:text-left text-base hover:underline ">Política de privacidade</a>
            <a :href="route('resolution')" class="text-white text-center xl:text-left text-base hover:underline">Resolução de Litígios</a>
        </nav>

        <!-- Páginas -->
        <nav class="flex flex-col items-center xl:items-start" aria-label="páginas">
            <h6 class="text-base text-left xl:text-left xl:text-xl text-white font-bold mb-2">Páginas</h6>
            <a :href="route('about')" class="text-white text-base text-center xl:text-left hover:underline mb-2">Sobre
                Nós</a>
            <a :href="route('services')"
                class="text-white text-base text-center xl:text-left hover:underline mb-2">Serviços</a>
            <a :href="route('materials')"
                class="text-white text-base text-center xl:text-left hover:underline mb-2">Materiais</a>
            <a :href="route('portfolio')"
                class="text-white text-base text-center xl:text-left hover:underline mb-2">Portfólio</a>
            <a :href="route('contacts')"
                class="text-white text-base text-center xl:text-left hover:underline">Contactos</a>
        </nav>

        <!-- Kitchen Image -->
        <aside class="flex justify-center items-center xl:justify-start">
            <img :src="kitchen" alt="kitchen" class="w-48 sm:w-64 lg:w-72 transform -scale-x-100 mx-5">
        </aside>
    </footer>
</template>


<script>
import logo from "@/assets/images/logo/logotipo.svg";
import kitchen from "@/assets/images/footer/cozinhas tecozi refeito.svg";

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
