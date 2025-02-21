<template>
    <section class="relative min-h-screen py-10 bg-gradient-to-br from-gray-100 via-gray-50 to-white">
        <!-- Imagem de fundo -->
        <img :src="kitchen" alt="Fundo Inferior Direito"
            class="absolute bottom-0 right-0 w-48 xl:w-60 scale-x-[-1] opacity-50 z-0" />

        <!-- TÍTULO E DESCRIÇÃO -->
        <div class="flex flex-col justify-center mx-10 mt-20 mb-12 text-center xl:text-left">
            <h1 class="text-xl xl:text-3xl  tracking-wide text-gray-800 animate-fadeIn">
                Trabalhamos com as melhores <span class="text-secondary-default">Marcas do Mercado</span>
            </h1>
            <p class="text-lg mt-4 max-w-5xl mx-auto xl:mx-0 text-gray-700 animate-fadeIn delay-200">
                Trabalho de qualidade acompanhado dos melhores materiais em cada projeto realizado! Os materiais que
                garantem o melhor resultado: </p>
        </div>

        <!-- CONTAINER PRINCIPAL -->
        <div class="flex flex-col gap-10 mx-10 mb-10 relative z-10">
            <!-- LISTA DE MATERIAIS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 w-full">
                <div v-for="material in materials" :key="material.id" class="rounded-xl bg-white p-6 flex flex-col items-center cursor-pointer shadow-xl relative overflow-hidden
                           transition-all duration-500 transform hover:scale-105 hover:shadow-2xl group"
                    :class="{ 'border-4 border-secondary-default bg-gray-100': activeMaterial?.id === material.id }"
                    @click="setActiveMaterial(material)">

                    <!-- Imagem com profundidade -->
                    <div
                        class="relative w-48 h-48 overflow-hidden rounded-lg shadow-md transition-all duration-500 transform group-hover:scale-110">
                        <img :src="material.photo" :alt="material.title"
                            class="w-full h-full object-cover brightness-110 group-hover:brightness-125" />
                    </div>

                    <!-- Título com efeito de brilho -->
                    <h3
                        class="mt-5 text-xl font-semibold text-center text-primary-default group-hover:text-secondary-default transition-all">
                        {{ material.title }}
                    </h3>
                </div>
            </div>

            <!-- DETALHES DO MATERIAL SELECIONADO -->
            <div class="w-full relative flex-grow rounded-xl p-8 shadow-2xl bg-gradient-to-bl from-white via-gray-100 to-white
                        backdrop-blur-md border-l-4 border-secondary-default transition-all duration-500 animate-fadeIn">
                <transition name="fade-up" mode="out-in">
                    <div v-if="activeMaterial" :key="activeMaterial.id"
                        class="p-6 rounded-lg shadow-md bg-white/80 animate-fadeIn">
                        <h2 class="text-lg xl:text-2xl font-bold mb-4 border-secondary-default tracking-wide">
                            {{ activeMaterial.title }}
                        </h2>
                        <p class="mb-6 text-gray-700 text-lg leading-relaxed">
                            {{ activeMaterial.description }}
                        </p>

                        <!-- GALERIA INTERATIVA COM SPLIDE -->
                        <Splide v-if="activeMaterial.gallery.length" class="mt-6" :options="splideOptions">
                            <SplideSlide v-for="(photo, index) in activeMaterial.gallery" :key="index">
                                <img :src="photo" :alt="'Imagem ' + (index + 1)"
                                    class="w-full h-64 object-cover rounded-lg shadow-lg cursor-pointer transition-all duration-500 hover:scale-110"
                                    @click="openModal(photo)" />
                            </SplideSlide>
                        </Splide>
                    </div>
                </transition>
            </div>
        </div>

        <!-- MODAL PARA VISUALIZAÇÃO DE IMAGENS -->
        <div v-if="showModal"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 z-50 transition-opacity duration-500">
            <div class="bg-white p-8 rounded-xl shadow-2xl relative max-w-3xl w-full">
                <button @click="closeModal"
                    class="absolute top-3 right-3 text-gray-700 text-4xl hover:text-red-500 transition-all">
                    &times;
                </button>
                <img :src="modalImage" alt="Imagem ampliada"
                    class="w-full h-auto rounded-lg shadow-lg transition-transform duration-300 hover:scale-105" />
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";
import kitchen from "@/assets/images/footer/kitchnet.svg";
import '@splidejs/splide/dist/css/splide.min.css';
import { Splide, SplideSlide } from '@splidejs/vue-splide';

export default {
    name: "Materials",
    components: { Splide, SplideSlide },
    data() {
        return {
            materials: [],
            activeMaterial: null,
            kitchen,
            showModal: false,
            modalImage: null,
            splideOptions: {
                type: 'loop',
                perPage: 3,
                perMove: 1,
                focus: 'center',
                autoplay: true,
                interval: 3000,
                gap: '1rem',
                pauseOnHover: true,
                pagination: false,
                arrows: true,
                breakpoints: {
                    1024: { perPage: 2 },
                    768: { perPage: 1 }
                }
            }
        };
    },
    methods: {
        async fetchMaterials() {
            try {
                const response = await axios.get("/api/materials");
                this.materials = response.data;

                // Definir o primeiro material como ativo por padrão
                if (this.materials.length) {
                    this.activeMaterial = this.materials[0];
                }
            } catch (error) {
                console.error("Erro ao carregar materiais:", error);
            }
        },
        setActiveMaterial(material) {
            this.activeMaterial = material;
        },
        openModal(photo) {
            this.modalImage = photo;
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
            this.modalImage = null;
        }
    },
    created() {
        this.fetchMaterials();
    }
};
</script>

<style scoped>
/* Animação de Fade-In */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.6s ease forwards;
}

/* Transição Suave */
.fade-up-enter-active,
.fade-up-leave-active {
    transition: all 0.4s ease-in-out;
}

.fade-up-enter {
    opacity: 0;
    transform: translateY(15px);
}

.fade-up-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

/* Hover */
.hover\:scale-105:hover {
    transform: scale(1.05);
}

/* Sombras Profundas */
.shadow-lg {
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
}

.shadow-2xl {
    box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.25);
}
</style>
