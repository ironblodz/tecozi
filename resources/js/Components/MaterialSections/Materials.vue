<template>
    <section class="relative min-h-screen py-10 bg-gradient-to-br from-white via-gray-50 to-gray-100">
        <!-- Imagem de fundo -->
        <img :src="kitchen" alt="Fundo Inferior Direito"
            class="absolute bottom-0 right-0 w-48 xl:w-60 scale-x-[-1] opacity-80 z-0" />

        <!-- TÍTULO E DESCRIÇÃO -->
        <div class="flex flex-col justify-center mx-10 mt-24 mb-10 text-center xl:text-left">
            <h1 class="text-primary-default text-3xl xl:text-4xl font-bold mb-4 z-20 tracking-wide">
                Trabalhamos com os <span class="text-secondary-default">melhores materiais</span> do mercado
            </h1>
            <p class="text-lg xl:text-xl max-w-7xl mx-auto xl:mx-0 text-gray-700">
                Trabalho de qualidade acompanhado dos melhores materiais em cada projeto realizado!
                Os materiais que garantem o melhor resultado.
            </p>
        </div>

        <!-- CONTAINER PRINCIPAL -->
        <div class="flex flex-col gap-8 mx-10 mb-8 relative z-10">
            <!-- COLUNA ESQUERDA: Lista de Materiais -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 w-full">
                <div v-for="material in materials" :key="material.id"
                    class="shadow-lg rounded-lg bg-white text-black p-6 flex flex-col items-center cursor-pointer
                           transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                    :class="{ 'border-4 border-[#BF0404] bg-primary-default': activeMaterial?.id === material.id }"
                    @click="setActiveMaterial(material)">
                    <img :src="material.photo" :alt="material.title" class="w-40 h-40 object-cover rounded-lg shadow-md mb-4" />
                    <p class="font-semibold text-xl xl:text-2xl text-center">{{ material.title }}</p>
                </div>
            </div>

            <!-- COLUNA DIREITA: Detalhes do Material Selecionado -->
            <div class="w-full relative flex-grow rounded-xl p-8 shadow-2xl bg-gradient-to-bl from-white via-gray-100 to-white backdrop-blur-md border-l-4 border-[#BF0404] transition-all duration-300">
                <transition name="zoom-fade" mode="out-in">
                    <div v-if="activeMaterial" :key="activeMaterial.id" class="p-6 rounded-lg shadow-md bg-white/80 animate-contentFadeIn">
                        <h2 class="text-2xl font-bold mb-4 text-primary-default tracking-wide">
                            {{ activeMaterial.title }}
                        </h2>
                        <p class="mb-6 text-gray-700 text-lg leading-relaxed">
                            {{ activeMaterial.description }}
                        </p>

                        <!-- Galeria de fotos -->
                        <div v-if="activeMaterial.gallery.length" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6 gap-6 mt-6">
                            <div v-for="(photo, index) in activeMaterial.gallery" :key="index" class="relative group">
                                <img :src="photo" :alt="`Imagem ${index + 1}`" loading="lazy"
                                    class="w-64 h-64 object-cover rounded-md shadow-lg transform transition-transform duration-300 group-hover:scale-110 cursor-pointer"
                                    @click="openModal(photo)" />
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>

        <!-- MODAL PARA VISUALIZAÇÃO DE IMAGENS -->
        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg relative">
                <button @click="closeModal" class="absolute top-2 right-2 text-gray-600 text-3xl hover:text-red-500 transition">
                    &times;
                </button>
                <img :src="modalImage" alt="Imagem ampliada" class="w-full max-w-lg mx-auto rounded-md shadow-lg" />
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";
import kitchen from "@/assets/images/footer/kitchnet.svg";

export default {
    name: "Materials",
    data() {
        return {
            materials: [],
            activeMaterial: null,
            kitchen,
            showModal: false,
            modalImage: null
        };
    },
    methods: {
        async fetchMaterials() {
            try {
                const response = await axios.get("/api/materials"); // Buscar todos os materiais
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
/* Transição de Fade-In */
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

.animate-contentFadeIn {
    animation: fadeIn 0.4s ease forwards;
}

/* Zoom Fade Transition */
.zoom-fade-enter-active,
.zoom-fade-leave-active {
    transition: all 0.3s ease-in-out;
}
.zoom-fade-enter {
    opacity: 0;
    transform: scale(0.9);
}
.zoom-fade-leave-to {
    opacity: 0;
    transform: scale(1.05);
}

/* Efeito Hover nos Materiais */
.hover\:scale-105:hover {
    transform: scale(1.05);
}

/* Sombra elegante */
.shadow-md {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.shadow-lg {
    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.15);
}

.shadow-2xl {
    box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.2);
}
</style>
