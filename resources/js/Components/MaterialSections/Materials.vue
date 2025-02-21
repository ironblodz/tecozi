<template>
    <section class="relative min-h-screen py-10 px-6 bg-gradient-to-br bg-gray-700 text-white overflow-hidden">
        <!-- Imagem de fundo animada -->
        <div class="absolute inset-0 bg-cover bg-center opacity-20" :style="{ backgroundImage: `url(${kitchen})` }"></div>

        <!-- Título e Descrição -->
        <div class="text-center max-w-4xl mx-auto mb-12 mt-32">
            <h1 class="text-4xl font-extrabold tracking-wide">
                Trabalhamos com as <span class="text-secondary-default">melhores marcas do mercado</span>
            </h1>
            <p class="text-lg text-gray-300 mt-4">
                Trabalho de qualidade acompanhado dos melhores materiais em cada projeto realizado! Os materiais que garantem o melhor resultado:
            </p>
        </div>

        <!-- Lista de Materiais -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-8 relative z-10">
            <div v-for="material in materials" :key="material.id"
                class="group bg-primary-default rounded-xl shadow-lg p-6 flex flex-col items-center cursor-pointer transition-transform transform hover:scale-105"
                @click="setActiveMaterial(material)">
                <div class="relative w-32 h-32 mb-4 overflow-hidden rounded-xl">
                    <img :src="material.photo" :alt="material.title" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <p class="text-lg font-semibold text-white">{{ material.title }}</p>
            </div>
        </div>

        <!-- Detalhes do Material Ativo -->
        <transition name="fade-slide">
            <div v-if="activeMaterial" class="fixed inset-0 flex items-center justify-center bg-black/60 z-50 p-6">
                <div class="bg-primary-default p-8 rounded-xl shadow-2xl max-w-2xl w-full relative">
                    <button class="absolute top-4 right-4 text-gray-300 hover:text-white text-xl" @click="activeMaterial = null">&times;</button>
                    <h3 class="text-2xl font-bold text-red-400 mb-4">{{ activeMaterial.title }}</h3>
                    <p class="text-gray-300 mb-6">{{ activeMaterial.description }}</p>
                    <div v-if="activeMaterial.gallery.length" class="grid grid-cols-2 gap-4">
                        <img v-for="(image, index) in activeMaterial.gallery" :key="index" :src="image"
                            class="w-full h-32 object-cover rounded-lg shadow-md">
                    </div>
                </div>
            </div>
        </transition>
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
            materials: [],
            activeMaterial: null
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
        this.fetchMaterials();
    }
};
</script>

<style>
.fade-slide-enter-active, .fade-slide-leave-active {
    transition: all 0.3s ease;
}
.fade-slide-enter, .fade-slide-leave-to {
    transform: translateY(-10px);
    opacity: 0;
}
</style>
