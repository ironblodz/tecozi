<template>
    <section class="relative min-h-screen py-10 bg-gradient-to-br from-white via-gray-50 to-gray-100">
        <!-- Imagem de fundo -->
        <img :src="kitchen" alt="Fundo Inferior Direito"
            class="absolute bottom-0 right-0 w-48 xl:w-60 scale-x-[-1] opacity-80 z-0" />

        <!-- TÍTULO E DESCRIÇÃO -->
        <div class="flex flex-col justify-center mx-10 mt-24 mb-10 text-center xl:text-left">
            <h1 class="text-primary-default text-2xl xl:text-3xl mb-3 z-20 tracking-wide">
                Trabalhamos com as
                <span class="text-secondary-default">melhores marcas</span>
                do mercado
            </h1>
            <p class="text-base xl:text-lg max-w-7xl mx-auto xl:mx-0 text-gray-600">
                Trabalho de qualidade acompanhado dos melhores materiais em cada projeto realizado!
                Os materiais que garantem o melhor resultado.
            </p>
        </div>
        <!-- FIM TÍTULO E DESCRIÇÃO -->

        <!-- CONTAINER PRINCIPAL -->
        <div class="flex flex-col gap-6 mx-10 mb-8 relative z-10">
            <!-- COLUNA ESQUERDA -->
            <div class="flex flex-row flex-wrap w-full gap-6 justify-center">
                <div v-for="material in materials" :key="material.id" :class="[
                    'shadow-md rounded-lg bg-white text-black p-4',
                    'w-72 xl:w-56 flex flex-col items-center',
                    'cursor-pointer relative transition-transform duration-300',
                    'hover:scale-105 hover:shadow-lg',
                    activeMaterial?.id === material.id ? 'border-4 border-[#BF0404] bg-primary-default' : ''
                ]" @click="setActiveMaterial(material)">
                    <img :src="material.photo" :alt="material.title" class="w-32 h-32 object-contain mb-4 rounded-2xl" />
                    <p class="font-semibold text-lg xl:text-2xl text-center">{{ material.title }}</p>
                </div>
            </div>

            <!-- COLUNA DIREITA -->
            <div class="relative w-full flex-grow rounded-xl p-6 shadow-2xl
               bg-gradient-to-bl from-white via-gray-100 to-white
               backdrop-blur-md border-l-4 border-[#BF0404]
               transition-all duration-300">
                <!-- Exibir informações do material ativo -->
                <div v-if="activeMaterial" class="p-5 mt-2 mb-2 rounded-lg shadow-md bg-white/80 animate-contentFadeIn">
                    <h3 class="text-lg font-semibold mb-2 text-gray-700">
                        {{ activeMaterial.title }}
                    </h3>
                    <p class="mb-4 text-gray-700 leading-relaxed">
                        {{ activeMaterial.description }}
                    </p>

                    <!-- Galeria de Imagens -->
                    <div v-if="activeMaterial.gallery.length" class="mt-4">
                        <h4 class="text-gray-700 font-semibold mb-2">Galeria de Fotos</h4>
                        <div class="grid grid-cols-3 justify-items-center gap-2">
                            <img v-for="(image, index) in activeMaterial.gallery" :key="index" :src="image"
                                class="w-full h-52 object-cover rounded-md shadow cursor-pointer transition">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import kitchen from "@/assets/images/footer/kitchnet.svg";
import axios from "axios";

export default {
    name: "Materials",
    data() {
        return {
            kitchen,
            materials: [], // Lista de materiais
            activeMaterial: null // Material selecionado
        };
    },
    methods: {
        async fetchMaterials() {
            try {
                const response = await axios.get("/api/materials");
                this.materials = response.data.materials;
            } catch (error) {
                console.error("Erro ao buscar materiais:", error);
            }
        },
        setActiveMaterial(material) {
            this.activeMaterial = material;
        }
    },
    mounted() {
        this.fetchMaterials(); // Buscar materiais ao carregar a página
    }
};
</script>
