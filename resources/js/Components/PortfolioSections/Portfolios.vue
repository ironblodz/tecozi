<template>
    <section class="container mx-auto">
        <div class="mt-16 xl:mt-20 mx-auto xl:max-w-6xl">
            <div class="flex flex-col items-center xl:items-baseline z-20 mb-4">
                <h1 class="text-2xl xl:text-3xl text-left text-primary-default mt-12">Portfólio de <span
                        class="text-secondary-default text-2xl xl:text-3xl">Projetos realizados</span></h1>
            </div>
            <div class="flex flex-col xl:flex-row justify-center">
                <div class="relative flex items-center mx-5 px-10 bg-gray-100 xl:h-[650px] rounded-lg xl:mt-[24px]">
                    <!-- Imagem de fundo -->
                    <img class="absolute inset-0 w-full h-full object-cover rounded-lg z-0" :src="KitchenWallpaperGrey"
                        alt="Background" />

                    <!-- Botões de categorias -->
                    <div class="relative z-10 flex flex-col w-full xl:h-full items-center py-4 bg-opacity-70 mt-2">
                        <div class="flex flex-row xl:flex-col">
                            <!-- Botão 'Todos' -->
                            <button type="button" @click="filterByCategory(null)" :class="[
                                'text-base xl:text-lg font-medium px-2 xl:px-1 mr-2 py-1 text-center mb-3 w-full rounded-full',
                                selectedCategory === null
                                    ? 'text-white bg-primary-default border-primary-default'
                                    : 'text-black border bg-gray-300'
                            ]">
                                Todos
                            </button>

                            <!-- Skeleton loader para categorias -->
                            <v-skeleton-loader v-if="isLoading" :loading="isLoading" type="list-item"
                                class="w-full mb-3">
                                <template #default>
                                    <div v-for="n in 3" :key="n"
                                        class="w-full h-10 bg-gray-300 animate-pulse rounded-full mb-3"></div>
                                </template>
                            </v-skeleton-loader>

                            <!-- Categorias carregadas -->
                            <div v-else>
                                <div v-for="category in sortedCategories" :key="category.id">
                                    <button @click="filterByCategory(category.id)" :class="[
                                        'text-base xl:text-lg font-medium px-10 py-1 text-center mb-3 w-full rounded-full',
                                        selectedCategory === category.id
                                            ? 'text-white bg-primary-default border-primary-default'
                                            : 'text-black border bg-gray-300'
                                    ]">
                                        {{ category.name }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 rounded-lg mt-[22px] min-w-full">
                    <!-- Skeleton loader para projetos -->
                    <v-skeleton-loader v-if="isLoading" :loading="isLoading" type="card" class="w-full h-48">
                        <template #default>
                            <div v-for="index in 5" :key="index"
                                class="w-full h-48 bg-gray-300 animate-pulse mb-4 rounded-lg"></div>
                        </template>
                    </v-skeleton-loader>

                    <div v-else>
                        <div v-if="filteredProjects.length > 0"
                            class="grid grid-cols-2 justify-center xl:mt-6 mx-6 xl:grid-cols-5 gap-4 mb-5 bg-gray-100 rounded-full">
                            <div class="relative group bg-gray-100" v-for="(project, index) in paginatedProjects"
                                :key="index">
                                <div class="relative overflow-hidden rounded-lg shadow-lg">
                                    <!-- Imagem do projeto -->
                                    <img @click="openModal(project)"
                                        class="w-full h-48 object-cover transition-transform duration-500 transform group-hover:scale-110"
                                        :src="project.main_image ? `/storage/${project.main_image}` : 'default-image.jpg'"
                                        :alt="project.title" />

                                    <!-- Informações ao passar o mouse -->
                                    <div
                                        class="text-base xl:text-lg absolute bottom-0 left-0 w-full h-[44%] bg-black/50 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-500 p-4 border-t-4 border-secondary-default">
                                        <h3 class="font-semibold text-base">{{ project.title }}</h3>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div v-else class="text-center mt-10">
                            <p class="text-gray-500 text-base xl:text-lg">Nenhum projeto encontrado.</p>
                            <p v-if="error" class="text-red-500 text-base xl:text-lg">{{ error }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
                @click="closeModal">
                <div class="relative max-w-full max-h-full" @click.stop>
                    <!-- Botão de fechar -->
                    <button @click="closeModal" class="absolute top-0 right-0 text-white text-3xl p-2">
                        &times;
                    </button>

                    <!-- Container para imagem e informações -->
                    <div class="relative group">
                        <!-- Imagem em tamanho grande -->
                        <img :src="selectedProject.main_image ? `/storage/${selectedProject.main_image}` : 'default-image.jpg'"
                            class="w-full h-96 object-cover transition-transform duration-500 transform group-hover:scale-110"
                            :alt="selectedProject.title" />

                        <!-- Título e descrição do projeto -->
                        <div
                            class="absolute inset-0 flex justify-center items-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 p-4 rounded-2xl">
                            <div class="text-center text-white">
                                <h3 class="text-2xl font-semibold">{{ selectedProject.title }}</h3>
                                <p class="mt-2">{{ selectedProject.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paginação -->
            <div v-if="filteredProjects.length > 0" class="flex justify-between items-center mb-10 px-10 mt-5">
                <!-- Botão Voltar -->
                <p v-if="currentPage > 1" @click="goToPage(currentPage - 1)"
                    class="cursor-pointer text-black mx-3 text-base xl:text-xl">
                    <i class="fas fa-arrow-left"></i> Voltar
                </p>

                <!-- Números de páginas -->
                <ul class="flex space-x-2">
                    <li v-for="page in pageNumbers" :key="page" @click="goToPage(page)"
                        :class="{ 'text-black text-base xl:text-xl': currentPage !== page, 'text-white rounded-full px-2 bg-secondary-default text-base xl:text-xl': currentPage === page }"
                        class="cursor-pointer">
                        {{ page }}
                    </li>
                </ul>

                <!-- Botão Próximo -->
                <p v-if="currentPage < totalPages" @click="goToPage(currentPage + 1)"
                    class="cursor-pointer text-base xl:text-xl text-black mx-3">
                    Próximo <i class="fas fa-arrow-right"></i>
                </p>
            </div>

            <blockquote class="text-center mb-10">
                <p class="font-bold text-base xl:text-lg">"A qualidade nunca é um acidente; é sempre o resultado de um
                    esforço inteligente."</p>
                <cite>— John Ruskine</cite>
            </blockquote>
        </div>
    </section>
</template>

<script>
import axios from 'axios'; // Importa o Axios
import { ref, computed } from 'vue';
import KitchenWallpaperGrey from '@/assets/images/services/kitechenwallpapergrey.svg';

const isLoading = ref(true); // Estado de carregamento

export default {
    name: "Portfolios",
    setup() {
        // Refs e estados
        const projects = ref([]);
        const filteredProjects = ref([]);
        const categories = ref([]);
        const error = ref(null);
        const currentPage = ref(1);
        const itemsPerPage = 15;
        const showModal = ref(false); // Controla a visibilidade do modal
        const selectedProject = ref({}); // Armazena o projeto selecionado
        const selectedCategory = ref(null); // Categoria selecionada

        // Método para buscar os projetos e categorias
        const fetchProjectsAndCategories = async () => {
            try {
                isLoading.value = true; // Inicia o carregamento

                // Requisição para pegar os projetos
                const projectResponse = await axios.get('/api/portfolios');
                const categoryResponse = await axios.get('/api/categories');

                projects.value = projectResponse.data || [];
                filteredProjects.value = [...projects.value]; // Inicializa com todos os projetos
                categories.value = categoryResponse.data || []; // Atualiza as categorias

                isLoading.value = false; // Finaliza o carregamento
            } catch (err) {
                error.value = err.message || 'Erro desconhecido';
                isLoading.value = false; // Finaliza o carregamento em caso de erro
            }
        };

        // Carregar os projetos e categorias ao iniciar
        fetchProjectsAndCategories();


        const sortedCategories = computed(() => {
            const order = ['cozinhas', 'roupeiros', 'closets', 'acessórios'];

            const sortedList = [...categories.value];
            return sortedList.sort((a, b) => {
                return order.indexOf(a.name) - order.indexOf(b.name);
            });
        });


        const totalPages = computed(() => {
            return Math.ceil(filteredProjects.value.length / itemsPerPage);
        });


        const paginatedProjects = computed(() => {
            const start = (currentPage.value - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            return filteredProjects.value.slice(start, end);
        });


        const pageNumbers = computed(() => {
            const numbers = [];
            for (let i = 1; i <= totalPages.value; i++) {
                numbers.push(i);
            }
            return numbers;
        });


        const goToPage = (page) => {
            if (page < 1 || page > totalPages.value) return;
            currentPage.value = page;
        };

        const filterByCategory = (categoryId) => {
            selectedCategory.value = categoryId;
            if (categoryId === null) {
                filteredProjects.value = [...projects.value];
            } else {
                filteredProjects.value = projects.value.filter(
                    project => project.category_id === categoryId
                );
            }
            currentPage.value = 1;
        };


        const openModal = (project) => {
            selectedProject.value = project;
            showModal.value = true;
        };

        // Função para fechar o modal
        const closeModal = () => {
            console.log('Fechando modal...');
            showModal.value = false;
            selectedProject.value = {};
        };

        // Retornar as propriedades para o template
        return {
            projects,
            sortedCategories,
            error,
            currentPage,
            totalPages,
            paginatedProjects,
            pageNumbers,
            goToPage,
            filteredProjects,
            selectedCategory,
            filterByCategory,
            showModal,
            selectedProject, // Adiciona o projeto selecionado
            KitchenWallpaperGrey,
            openModal,
            closeModal
        };
    },
};
</script>



<style scoped>
/* Modal */
.fixed {
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}
</style>
