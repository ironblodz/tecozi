<template>
    <section>
        <div class="container mx-auto w-[85%] grid grid-cols-1 justify-center mt-10 xl:mt-20">
            <img :src="wallpaperkitchen" alt="kitchen" class="absolute transform scale-x-[-1] w-72">
            <div class="bg-gray-100 rounded-lg pt-10 pb-20">
                <div class="flex flex-col items-center px-4">
                    <h1 class="text-xl xl:text-3xl text-center text-primary-default z-10 xl:z-0">
                        {{ $t('projectsfeactures.projects') }}
                        <span class="text-secondary-default text-xl xl:text-3xl z-10 xl:z-0">
                            {{ $t('projectsfeactures.projectscc') }}
                        </span>
                    </h1>
                    <p class="text-base xl:text-lg mt-8 text-center z-10" v-html="$t('projectsfeactures.projectsp')">
                    </p>
                </div>

                <!-- Exibição dos projetos destacados -->
                <div v-if="featuredProjects.length > 0"
                    class="flex flex-col xl:flex-row gap-4 items-center justify-center mt-10">
                    <div v-for="project in featuredProjects" :key="project.id"
                        class="card w-72 h-80 xl:h-96 relative overflow-hidden border-4 border-primary-default">
                        <img :src="getImageUrl(project.main_image)" :alt="project.title"
                            class="absolute inset-0 w-full h-full object-cover cursor-pointer"
                            @click="openModal(project)" />

                        <div
                            class="absolute bottom-4 -right-[2rem] bg-primary-default text-white px-4 py-2 rounded-s-3xl text-base xl:text-lg min-w-24 mx-5">
                            <p>{{ project.title }}</p>
                        </div>
                        <p
                            class="text-base xl:text-lg mt-4 text-white bg-secondary-default  px-2 rounded-s-3xl w-[35%] relative ml-auto text-right">
                            {{ project.category ? project.category.name : 'Categoria desconhecida' }}
                        </p>

                    </div>
                </div>
                <p class="text-center text-primary-default text-bold text-base xl:text-lg mt-7" v-else>
                    Carregando projetos ou nenhum projeto encontrado.
                </p>
            </div>
        </div>

        <!-- Modal com Swiper -->
        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50">
            <div class="relative w-[95%] md:w-[65%] xl:w-[50%] bg-gray-200 rounded-2xl p-10 shadow-2xl transform scale-100  transition duration-300"
                @click.stop>
                <swiper v-if="selectedProject && selectedProject.images && selectedProject.images.length > 0"
                    :slides-per-view="1" :space-between="10"
                    :modules="[Navigation, Pagination, Autoplay, EffectCoverflow]" navigation pagination
                    :autoplay="{ delay: 4000, disableOnInteraction: false }" effect="coverflow" loop
                    class="rounded-2xl overflow-hidden">
                    <swiper-slide v-for="(image, index) in selectedProject.images" :key="index">
                        <img :src="getImageUrl(image.path)" alt="Imagem do projeto"
                            class="w-full h-96 object-cover rounded-2xl shadow-lg transition-transform duration-500 hover:scale-110" />
                    </swiper-slide>
                </swiper>

                <div class="text-center mt-6 text-white">
                    <h2 class="text-4xl font-extrabold text-secondary-default">{{ selectedProject.title }}</h2>
                    <p class="text-lg text-black mt-4">{{ selectedProject.description }}</p>
                </div>

                <button @click="closeModal"
                    class="absolute top-6 right-6 bg-red-500 text-white rounded-full p-4 shadow-lg text-xl transition hover:bg-red-700 hover:rotate-90 z-10">✕</button>
            </div>
        </div>

    </section>
</template>


<script setup>
import axios from 'axios';
import wallpaperkitchen from '@/assets/images/services/kitechenwallpapergrey.svg';

import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Autoplay, EffectCoverflow } from 'swiper/modules';


// Importação dos estilos necessários do Swiper
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

// Estado reativo (Vue 3 - Composition API)
import { ref, onMounted } from 'vue';

// Estado do componente
const featuredProjects = ref([]);
const categories = ref([]);
const showModal = ref(false);
const selectedProject = ref(null);

// Função para obter projetos destacados
const fetchFeaturedProjects = async () => {
    try {
        const response = await axios.get('/api/featured-portfolios');
        console.log('Projetos destacados:', response.data);
        featuredProjects.value = response.data;
    } catch (error) {
        console.error('Erro ao buscar os projetos:', error);
    }
};

// Função para obter categorias
const fetchCategories = async () => {
    try {
        const response = await axios.get('/api/categories');
        categories.value = response.data;
    } catch (error) {
        console.error('Erro ao buscar categorias:', error);
    }
};

// Função para abrir o modal e exibir o carrossel
const openModal = (project) => {
    console.log("Projeto selecionado para o modal:", project);

    selectedProject.value = {
        ...project,
        images: project.images && project.images.length > 0 ? project.images : [{ path: project.main_image }]
    };

    console.log("Imagens carregadas no modal:", selectedProject.value.images);

    showModal.value = true;
    document.body.classList.add('overflow-hidden');
};


// Fechar modal
const closeModal = () => {
    showModal.value = false;
    selectedProject.value = null;
    document.body.classList.remove('overflow-hidden');
};

// Obter URL da imagem corretamente
const getImageUrl = (imagePath) => {
    return imagePath ? `/storage/${imagePath}` : '/images/default-placeholder.jpg';
};

// Obter nome da categoria pelo ID
const getCategoryName = (categoryId) => {
    const category = categories.value.find(cat => String(cat.id) === String(categoryId));
    return category ? category.name : 'Categoria desconhecida';
};

// Carregar dados ao montar o componente
onMounted(() => {
    fetchFeaturedProjects();
    fetchCategories();
});
</script>


<style scoped>

.fixed.inset-0 {
    z-index: 99999;
}

.group:hover .group-hover\:opacity-100 {
    opacity: 1;
    border-radius: 5%;
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.group img {
    border-radius: 15px;
    transition: border-radius 0.3s ease;
}

.menu {
    position: relative;
    /* ou absolute, mas com z-index controlado */
    z-index: 100;
    /* Certifique-se de que seja menor que o modal */
}

.fixed.inset-0 {
    width: 100vw;
    height: 100vh;
}

:deep(.swiper-button-next),
:deep(.swiper-button-prev) {
    color: #3D4877 !important;
    /* Altere para a cor desejada */
}

/* Mudar a cor das bolinhas da paginação */
:deep(.swiper-pagination-bullet) {
    background-color: #3D4877 !important;
    /* Cor das bolinhas */
    opacity: 1;
}

:deep(.swiper-pagination-bullet-active) {
    background-color: #BF0404 !important;
    /* Cor da bolinha ativa */
}
</style>
