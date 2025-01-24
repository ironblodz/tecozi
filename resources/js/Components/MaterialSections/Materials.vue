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
                <div v-for="category in categories" :key="category.id" :class="[
                    'shadow-md rounded-lg bg-white text-black p-4',
                    'w-72 xl:w-56 flex flex-col items-center',
                    'cursor-pointer relative transition-transform duration-300',
                    'hover:scale-105 hover:shadow-lg',
                    activeCategory?.id === category.id ? 'border-4 border-[#BF0404] bg-primary-default' : ''
                ]" @click="setActiveCategory(category)">
                    <img :src="`/storage/${category.img}`" :alt="category.name" class="w-32 h-32 object-contain mb-4" />
                    <p class="font-semibold text-lg xl:text-2xl text-center">{{ category.name }}</p>
                </div>
            </div>

            <!-- COLUNA DIREITA -->
            <div class="relative w-full flex-grow rounded-xl p-6 shadow-2xl
               bg-gradient-to-bl from-white via-gray-100 to-white
               backdrop-blur-md border-l-4 border-[#BF0404]
               transition-all duration-300">
                <!-- Exibir informações da categoria ativa -->
                <div v-if="activeCategory" class="p-5 mt-2 mb-2 rounded-lg shadow-md bg-white/80 animate-contentFadeIn">
                    <h3 class="text-lg font-semibold mb-2 text-gray-700">
                        {{ activeCategory.subtitle }}
                    </h3>
                    <p class="mb-4 text-gray-700 leading-relaxed">
                        {{ activeCategory.description }}
                    </p>

                    <!-- Galeria de fotos aprimorada com Flowbite -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-6 mt-10">
                        <div v-for="photo in activeCategory.photos" :key="photo.id" class="relative group">
                            <img :src="`/storage/${photo.photo_path}`" :alt="`Foto ${activeCategory.name}`"
                                loading="lazy"
                                class="w-52 h-52 object-cover rounded-md shadow-lg transform transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                                @click="openModal(photo)" />
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
            activeCategory: null, // Categoria ativa
            categories: [], // Lista de categorias
            kitchen,
        };
    },
    methods: {
        async fetchCategories() {
            try {
                const response = await axios.get('/api/categories/visible-in-materials');
                this.categories = response.data;
                // Definir a primeira categoria como ativa por padrão
                if (this.categories.length) {
                    this.activeCategory = this.categories[0];
                }
            } catch (error) {
                console.error('Erro ao carregar categorias:', error);
            }
        },
        setActiveCategory(category) {
            this.activeCategory = category; // Atualizar a categoria ativa
        },
    },
    created() {
        this.fetchCategories();
    },
};
</script>



<style scoped>
/* ------------------------------------------
   TRANSIÇÃO DO CONTEÚDO (zoom-fade)
   Aqui, usamos classes personalizadas
------------------------------------------ */
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

/* ------------------------------------------
   CLASSE CUSTOM PARA O HOVER 3D
   (Tailwind não tem rotateX / rotateY prontos)
------------------------------------------ */
.hover\:card-3d-transform:hover {
    transform: perspective(600px) rotateX(6deg) rotateY(-6deg) scale(1.03);
    box-shadow: 0 15px 25px -5px rgba(0, 0, 0, 0.3);
}

/* ------------------------------------------
   ANIMAÇÃO DE FADE-IN (contentFadeIn)
------------------------------------------ */
@keyframes contentFadeIn {
    0% {
        opacity: 0;
        transform: translateY(15px);
    }

    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-contentFadeIn {
    animation: contentFadeIn 0.4s ease forwards;
}
</style>
