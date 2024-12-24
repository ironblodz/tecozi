<template>
    <section class="container mx-auto">
        <div class="mt-16 xl:mt-20 mx-auto xl:max-w-7xl">
            <div class="flex flex-col items-center xl:items-start z-20 ">
                <h1 class="text-2xl xl:text-3xl text-left xl:text-left text-primary-default mt-12">Os nossos <span
                        class="text-secondary-default text-2xl xl:text-3xl">Serviços</span></h1>
            </div>

            <div class="flex flex-col xl:flex-row gap-4 items-center justify-center xl:justify-normal mt-10 flex-wrap">
                <!-- Card 1 -->
                <div class="w-72 h-80 xl:h-96 relative overflow-hidden group">
                    <img :src="KitchenService" alt="Kitchen1" class="absolute inset-0 w-full h-full object-cover" />
                    <div
                        class="absolute bottom-0 w-full bg-primary-default text-white px-4 py-2 text-center border-t-4 border-secondary-default transition-all duration-1000 ease-in-out group-hover:h-1/2 group-hover:py-8">
                        <span class="block group-hover:hidden text-xl">Cozinhas</span>
                        <h1 class="hidden group-hover:block group-hover:mb-5 group-hover:font-bold group-hover:text-lg">
                            Cozinhas</h1>
                        <p class="hidden group-hover:block">Cozinhas práticas e funcionais que otimizar o espaço,
                            respeitando as três zonas de trabalho: guardar, lavar e cozinhar</p>
                    </div>

                    <div class="transition-all duration-500 ease-in-out group-hover:bottom-48"></div>
                </div>

                <!-- Card 2 -->
                <div class="w-72 h-80 xl:h-96 relative overflow-hidden group">
                    <img :src="ClosetService" alt="Kitchen2" class="absolute inset-0 w-full h-full object-cover" />
                    <div
                        class="absolute bottom-0 w-full bg-primary-default text-white px-4 py-2 text-center border-t-4 border-secondary-default transition-all duration-1000 ease-in-out group-hover:h-1/2 group-hover:py-8">
                        <span class="block group-hover:hidden text-xl">Roupeiros</span>
                        <h1 class="hidden group-hover:block group-hover:mb-5 group-hover:font-bold group-hover:text-lg">
                            Roupeiros</h1>
                        <p class="hidden group-hover:block">Roupeiros práticos e funcionais com elevada capacidade,
                            incluindo vários espaços de arrumação.</p>
                    </div>

                    <div class="transition-all duration-500 ease-in-out group-hover:bottom-48"></div>
                </div>

                <!-- Card 3 -->
                <div class="w-72 h-80 xl:h-96 relative overflow-hidden group">
                    <img :src="RoupeirosService" alt="Kitchen3" class="absolute inset-0 w-full h-full object-cover" />
                    <div
                        class="absolute bottom-0 w-full bg-primary-default text-white px-4 py-2 text-center border-t-4 border-secondary-default transition-all duration-1000 ease-in-out group-hover:h-1/2 group-hover:py-8">
                        <span class="block group-hover:hidden text-xl">Closets</span>
                        <h1 class="hidden group-hover:block group-hover:mb-5 group-hover:font-bold group-hover:text-lg">
                            Closets</h1>
                        <p class="hidden group-hover:block">Ambientes únicos com visualização imediata de todos os
                            itens, com organização personalizada.</p>
                    </div>

                    <div class="transition-all duration-500 ease-in-out group-hover:bottom-48"></div>
                </div>

                <!-- Card 4 -->
                <div class="w-72 h-80 xl:h-96 relative overflow-hidden group">
                    <img :src="OtherService" alt="Kitchen4" class="absolute inset-0 w-full h-full object-cover" />
                    <div
                        class="absolute bottom-0 w-full bg-primary-default text-white px-4 py-2 text-center border-t-4 border-secondary-default transition-all duration-1000 ease-in-out group-hover:h-1/2 group-hover:py-8">
                        <span class="block group-hover:hidden text-xl">Outros</span>
                        <h1 class="hidden group-hover:block group-hover:mb-5 group-hover:font-bold group-hover:text-lg">
                            Outros</h1>
                        <p class="hidden group-hover:block">Também realizamos outros tipos de trabalhos.</p>
                    </div>

                    <div class="transition-all duration-500 ease-in-out group-hover:bottom-48"></div>
                </div>
            </div>

            <!-- Seção da Timeline -->
            <div class="flex flex-col items-center xl:items-start max-w-full z-20 mt-10">
                <div class="w-full">
                    <h1 class="text-2xl xl:text-3xl text-center xl:text-left text-primary-default">Fases do <span
                            class="text-secondary-default text-2xl xl:text-3xl">Projeto</span></h1>
                    <p class="text-xl mt-8 text-center xl:text-left">Aqui estão as fases do nosso projeto,
                        mostrando o progresso e as
                        etapas importantes.</p>
                </div>
                <div class="relative mt-10 flex items-start justify-center xl:justify-normal">
                    <!-- Contêiner da Timeline -->
                    <div class="flex flex-col z-20 w-4/5 timeline-container">
                        <!-- Fase 1 -->
                        <div class="flex items-start mb-10">
                            <div class="flex-shrink-0">
                                <img :src="Fase1" alt="Fase 1" class="w-10 h-10" />
                            </div>
                            <div class="ml-4 mt-2 w-full">
                                <p class="text-xl">Após contacto, combinamos uma primeira visita à obra
                                    para recolher
                                    medidas e as ideias do cliente.</p>
                            </div>
                        </div>
                        <!-- Fase 2 -->
                        <div class="flex items-start mb-10">
                            <div class="flex-shrink-0">
                                <img :src="Fase2" alt="Fase 2" class="w-10 h-10" />
                            </div>
                            <div class="ml-4 mt-2 w-full">
                                <p class="text-xl">Apresentamos o projeto 3D e os materiais, seguido de uma
                                    proposta
                                    orçamentária personalizada.</p>
                            </div>
                        </div>
                        <!-- Fase 3 -->
                        <div class="flex items-start mb-10">
                            <div class="flex-shrink-0">
                                <img :src="Fase3" alt="Fase 3" class="w-10 h-10" />
                            </div>
                            <div class="ml-4 mt-2 w-full">
                                <p class="text-xl">Após a adjudicação voltamos à obra para retificar todas
                                    as medidas.
                                </p>
                            </div>
                        </div>
                        <!-- Fase 4 -->
                        <div class="flex items-start mb-10">
                            <div class="flex-shrink-0">
                                <img :src="Fase4" alt="Fase 4" class="w-10 h-10" />
                            </div>
                            <div class="ml-4 mt-2 w-full">
                                <p class="text-xl">Após definir todos os pormenores e prazos, realizamos e
                                    instalamos
                                    conforme combinado.</p>
                            </div>
                        </div>
                        <!-- Fase 5 -->
                        <div class="flex items-start mb-10">
                            <div class="flex-shrink-0">
                                <img :src="Fase5" alt="Fase 5" class="w-10 h-10" />
                            </div>
                            <div class="ml-4 mt-2 w-full">
                                <p class="text-xl">Realizamos acabamentos cuidados em cada obra para um
                                    melhor
                                    resultado.</p>
                            </div>
                        </div>
                        <!-- Fase 6 -->
                        <div class="flex items-start mb-10">
                            <div class="flex-shrink-0">
                                <img :src="Fase6" alt="Fase 6" class="w-10 h-10" />
                            </div>
                            <div class="ml-4 mt-2 w-full">
                                <p class="text-xl">Asseguramos um serviço pós-venda de qualidade e sempre
                                    disponível.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Linha conectando as fases -->
                    <div class="timeline-line"></div>
                </div>
            </div>
            <div class="flex flex-col xl:flex-row gap-8 items-center xl:items-start mt-10">
                <div class="flex flex-col justify ">
                    <img :src="KitchenWallpaperGrey" alt="Descrição da Imagem"
                        class="absolute transform scale-x-[-1] z-10 -ml-44 -mt-28 w-[300px] h-auto" />
                    <div class="flex flex-col items-center xl:items-start xl:justify-normal">
                        <h1 class="text-2xl xl:text-3xl text-center xl:text-left text-primary-default z-50">
                            Perguntas Frequentes <span class="text-secondary-default text-2xl xl:text-3xl">(Faqs)</span>
                        </h1>
                        <p class="text-xl mt-8 text-center xl:text-left z-50">
                            Encontre as respostas para as perguntas mais comuns sobre nossos serviços e processos.
                        </p>
                        <button
                            class="bg-primary-default text-xl text-white rounded-full mt-5 mb-5 p-2 w-64 z-50">Contactar</button>
                    </div>
                </div>

                <!-- Perguntas em Dropdown -->
                <div class="flex flex-col items-center xl:items-start xl:justify-normal w-full">
                    <!-- Pergunta -->
                    <div class="bg-slate-50 px-6 mb-2 w-full xl:max-w-5xl rounded-md">
                        <button @click="toggle(1)"
                            class="w-full text-left py-4 text-xl font-semibold focus:outline-none flex items-center justify-between">
                            <span class="text-md">O que é a carpintaria por medida?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform transform"
                                :class="{ 'rotate-90': activeIndex === 1 }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div v-if="activeIndex === 1"
                            class="text-xl xl:text-xl py-4 text-gray-700 transition-all duration-300">
                            É o serviço de criar móveis personalizados que se ajustam perfeitamente ao espaço e às
                            necessidades específicas de cada cliente.
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 mb-2 w-full xl:max-w-5xl rounded-md">
                        <button @click="toggle(2)"
                            class="w-full text-left py-4 text-xl font-semibold focus:outline-none flex items-center justify-between">
                            <span class="text-md">Quais as vantagens de ser desenvolvido à medida?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform transform"
                                :class="{ 'rotate-90': activeIndex === 2 }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div v-if="activeIndex === 2" class="text-xl py-4 text-gray-700 transition-all duration-300">
                            As principais vantagens incluem a otimização do espaço, personalização do design, escolha
                            dos materiais e a possibilidade de criar um ambiente único que reflete o seu estilo e
                            necessidades
                        </div>
                    </div>
                    <!-- Repetir para cada pergunta -->
                    <div class="bg-slate-50 px-6 mb-2 w-full  xl:max-w-5xl rounded-md">
                        <button @click="toggle(3)"
                            class="w-full text-left py-4 text-xl font-semibold focus:outline-none flex items-center justify-between">
                            <span>Posso ver exemplos de trabalhos realizados?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform transform"
                                :class="{ 'rotate-90': activeIndex === 3 }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div v-if="activeIndex === 3" class="text-xl py-4 text-gray-700 transition-all duration-300">
                            Sim, temos um portfólio de projetos que pode consultar aqui no nosso site. Ajudá-lo-á a
                            inspirar-se para o seu projeto.
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 mb-2 w-full  xl:max-w-5xl rounded-md">
                        <button @click="toggle(4)"
                            class="w-full text-left py-4 text-xl font-semibold focus:outline-none flex items-center justify-between">
                            <span> Como devo limpar a minha cozinha nova?
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform transform"
                                :class="{ 'rotate-90': activeIndex === 4 }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div v-if="activeIndex === 4" class="text-xl py-4 text-gray-700 transition-all duration-300">
                            Nas cozinhas termolaminadas pode usar um pano húmido (com pouca água) e detergente neutro,
                            isento de componentes agressivos/ abrasivos, passe de seguida um pano seco.
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 py-3 mb-2 w-full  xl:max-w-5xl rounded-md">
                        <button @click="toggle(5)"
                            class="w-full text-left py-4 text-xl font-semibold focus:outline-none flex items-center justify-between">
                            <span> O vosso serviço inclui as obras no espaço?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform transform"
                                :class="{ 'rotate-90': activeIndex === 5 }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div v-if="activeIndex === 5" class="text-xl py-4 text-gray-700 transition-all duration-300">
                            Não efetuamos a obras de estrutura, de canalização nem de instalações elétricas. Asseguramos
                            a instalação de móveis desenhados para o espaço comunicando com o empreiteiro, também
                            asseguramos as ligações de equipamentos incluídos no projeto desde que a instalação esteja
                            preparada.
                        </div>
                    </div>
                    <!-- Continue com as outras perguntas -->
                </div>
            </div>

        </div>
    </section>
</template>


<script>
import KitchenService from '@/assets/images/services/kitchenservice.svg';
import ClosetService from '@/assets/images/services/roupeirosservices.svg';
import RoupeirosService from '@/assets/images/services/closetsservice.svg';
import OtherService from '@/assets/images/services/otherservices.svg';
import KitchenWallpaper from '@/assets/images/services/kitchen_wallpaper.svg';
import KitchenWallpaperGrey from '@/assets/images/services/kitechenwallpapergrey.svg';

import Fase1 from '@/assets/images/services/fases1.svg';
import Fase2 from '@/assets/images/services/fases2.svg';
import Fase3 from '@/assets/images/services/fases3.svg';
import Fase4 from '@/assets/images/services/fases4.svg';
import Fase5 from '@/assets/images/services/fases5.svg';
import Fase6 from '@/assets/images/services/fases6.svg';

export default {
    name: "Service",
    data() {
        return {
            KitchenService,
            ClosetService,
            RoupeirosService,
            OtherService,
            Fase1,
            Fase2,
            Fase3,
            Fase4,
            Fase5,
            Fase6,
            KitchenWallpaper,
            KitchenWallpaperGrey,
            activeIndex: null,
        };
    },
    methods: {
        toggle(index) {
            // Se clicar na mesma pergunta, fecha. Senão, abre a pergunta clicada.
            this.activeIndex = this.activeIndex === index ? null : index;
        },
    },
};
</script>

<style scoped>
.group:hover .group-hover\:h-1\/2 {
    height: 50% !important;
}

.group:hover .group-hover\:py-8 {
    padding: 1rem 1rem;
}


</style>
