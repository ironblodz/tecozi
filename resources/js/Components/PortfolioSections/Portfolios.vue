<template>
    <section>
        <div class="flex flex-col z-20 mt-20 mb-2">
            <h1 class="text-2xl xl:text-3xl text-left text-primary-default mt-16 mx-16">
                Portfólio de <span class="text-secondary-default text-2xl xl:text-3xl">Projetos realizados</span>
            </h1>
        </div>

        <div class="container mx-auto xl:max-w-6xl">
            <div class="flex flex-col xl:flex-row justify-center">
                <div class="relative flex items-center mx-5 px-10 bg-gray-100 xl:h-[650px] rounded-lg xl:mt-[24px]">
                    <img class="absolute inset-0 w-full h-full object-cover rounded-lg z-0" :src="KitchenWallpaperGrey" alt="Background" />

                    <div class="relative z-10 flex flex-col w-full xl:h-full items-center py-4 bg-opacity-70 mt-2">
                        <div class="flex flex-row xl:flex-col">
                            <button type="button" @click="filterByCategory(null)" :class="[
                                'text-base xl:text-lg font-medium px-2 xl:px-1 mr-2 py-1 text-center mb-3 w-full rounded-full',
                                selectedCategory === null ? 'text-white bg-primary-default border-primary-default' : 'text-black border bg-gray-300'
                            ]">
                                Todos
                            </button>

                            <div v-for="category in sortedCategories" :key="category.id">
                                <button @click="filterByCategory(category.id)" :class="[
                                    'text-base xl:text-lg font-medium px-10 py-1 text-center mb-3 w-full rounded-full',
                                    selectedCategory === category.id ? 'text-white bg-primary-default border-primary-default' : 'text-black border bg-gray-300'
                                ]">
                                    {{ category.name }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-100 rounded-lg mt-[22px] min-w-full">
                    <div v-if="filteredProjects.length > 0"
                        class="grid grid-cols-2 justify-center xl:mt-6 mx-6 xl:grid-cols-5 gap-4 mb-5 bg-gray-100 rounded-full">
                        <div class="relative group bg-gray-100" v-for="(project, index) in paginatedProjects" :key="index">
                            <div class="relative overflow-hidden rounded-lg shadow-lg">
                                <img @click="openModal(project)"
                                    class="w-full h-48 object-cover transition-transform duration-500 transform group-hover:scale-110"
                                    :src="getImageUrl(project.main_image)"
                                    :alt="project.title" />

                                <div class="text-base xl:text-lg absolute bottom-0 left-0 w-full h-[44%] bg-black/50 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-500 p-4 border-t-4 border-secondary-default">
                                    <h3 class="font-semibold text-base">{{ project.title }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-else class="text-center mt-10">
                        <p class="text-gray-500 text-base xl:text-lg">Nenhum projeto encontrado.</p>
                    </div>
                </div>
            </div>

            <!-- Modal com Swiper -->
            <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
                @click="closeModal">
                <div class="relative group w-[90%] md:w-[60%] xl:w-[50%] bg-gray-200 p-6 rounded-lg shadow-lg" @click.stop>
                    <button @click="closeModal"
                        class="absolute top-4 right-4 bg-gray-200 text-black rounded-lg p-2 text-xl z-50">✕</button>

                    <!-- Carrossel Swiper -->
                    <swiper v-if="selectedProject && selectedProject.images && selectedProject.images.length > 0"
                        :slides-per-view="1"
                        :space-between="10"
                        :modules="[Navigation, Pagination]"
                        navigation
                        pagination
                        loop
                        class="rounded-xl">
                        <swiper-slide v-for="(image, index) in selectedProject.images" :key="index">
                            <img :src="getImageUrl(image.path)" alt="Imagem do projeto"
                                class="w-full h-auto object-cover rounded-xl" />
                        </swiper-slide>
                    </swiper>

                    <!-- Título e descrição -->
                    <div class="mt-4 text-center">
                        <h3 class="text-2xl font-semibold">{{ selectedProject.title }}</h3>
                        <p class="text-base mt-2">{{ selectedProject.description }}</p>
                    </div>
                </div>
            </div>

        </div>
    </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import KitchenWallpaperGrey from '@/assets/images/services/kitechenwallpapergrey.svg';

// ✅ Importação correta do Swiper.js
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination } from 'swiper/modules';

// ✅ Importação dos estilos necessários do Swiper
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

// ✅ Estado reativo
const projects = ref([]);
const filteredProjects = ref([]);
const categories = ref([]);
const showModal = ref(false);
const selectedProject = ref(null);
const selectedCategory = ref(null);
const currentPage = ref(1);
const itemsPerPage = 15;

// ✅ Buscar projetos e categorias
const fetchProjectsAndCategories = async () => {
    try {
        const projectResponse = await axios.get('/api/portfolios');
        const categoryResponse = await axios.get('/backoffice/portfolios/categories', {
            params: { visible_on_portfolio: true }
        });

        projects.value = projectResponse.data || [];
        filteredProjects.value = [...projects.value];
        categories.value = categoryResponse.data || [];

    } catch (err) {
        console.error('Erro ao buscar dados:', err);
    }
};

// ✅ Ordenar categorias
const sortedCategories = computed(() => {
    return categories.value.filter(category => !category.archived);
});

// ✅ Paginação
const totalPages = computed(() => Math.ceil(filteredProjects.value.length / itemsPerPage));
const paginatedProjects = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    return filteredProjects.value.slice(start, start + itemsPerPage);
});

// ✅ Filtrar por categoria
const filterByCategory = (categoryId) => {
    selectedCategory.value = categoryId;
    filteredProjects.value = categoryId ? projects.value.filter(p => p.category_id === categoryId) : [...projects.value];
};

// ✅ Abrir modal
const openModal = (project) => {
    selectedProject.value = {
        ...project,
        images: project.images?.length > 0 ? project.images : [{ path: project.main_image }]
    };
    showModal.value = true;
};

// ✅ Fechar modal
const closeModal = () => {
    showModal.value = false;
    selectedProject.value = null;
};

// ✅ Obter URL da imagem corretamente
const getImageUrl = (imagePath) => {
    return imagePath ? `/storage/${imagePath}` : '/images/default-placeholder.jpg';
};

// ✅ Carregar dados ao montar o componente
onMounted(fetchProjectsAndCategories);
</script>

<style scoped>
.fixed {
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

:deep(.swiper-button-next),
:deep(.swiper-button-prev) {
    color: #3D4877 !important; /* Altere para a cor desejada */
}

/* Mudar a cor das bolinhas da paginação */
:deep(.swiper-pagination-bullet) {
    background-color: #3D4877 !important; /* Cor das bolinhas */
    opacity: 1;
}

:deep(.swiper-pagination-bullet-active) {
    background-color: #BF0404 !important; /* Cor da bolinha ativa */
}
</style>
