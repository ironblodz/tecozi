<template>
    <section>
        <div class="container mx-auto w-full grid grid-cols-1 justify-center mt-10 xl:mt-20">
            <div class="flex flex-col items-center px-4 z-20">
                <h1 class="text-xl xl:text-3xl text-center text-primary-default">
                    {{ $t('projectsfeactures.projects') }}
                    <span class="text-secondary-default text-xl xl:text-3xl">
                        {{ $t('projectsfeactures.projectscc') }}
                    </span>
                </h1>
                <p class="text-base xl:text-lg mt-8 text-center" v-html="$t('projectsfeactures.projectsp')"></p>
            </div>
            <!-- Iterando sobre os projetos destacados -->
            <div v-if="featuredProjects.length > 0"
                class="flex flex-col xl:flex-row gap-4 items-center justify-center mt-10">
                <div v-for="(project, index) in featuredProjects" :key="project.id"
                    class="card w-72 h-80 xl:h-96 relative overflow-hidden">
                    <img :src="getImageUrl(project.main_image)" :alt="project.title"
                        class="absolute inset-0 w-full h-full object-cover cursor-pointer"
                        @click="openModal(getImageUrl(project.main_image), project)" />

                    <div
                        class="absolute bottom-4 right-[0rem] bg-primary-default text-white px-4 py-2 rounded-s-3xl text-base w-[250px]">
                        <p>{{ project.title }}</p>
                    </div>
                    <p
                        class="text-base mt-4 text-white bg-secondary-default  px-2 rounded-s-3xl w-[35%] relative ml-auto text-right">
                        {{ getCategoryName(project.category_id) }}
                    </p>
                </div>
            </div>
            <p class="text-center text-primary-default text-bold text-base xl:text-lg mt-7" v-else>Carregando projetos
                ou nenhum projeto encontrado.</p>
        </div>

        <!-- Modal para exibir a imagem em tamanho grande -->
        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50">
            <div class="relative group">
                <img :src="selectedImage" alt="Imagem do projeto" class="rounded-lg"
                    style="max-width: none; max-height: none;" />
                <!-- Texto sobreposto -->
                <div
                    class="absolute inset-0 flex flex-col justify-center items-center bg-black bg-opacity-50 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <h2 class="xl:text-2xl text-base font-bold text-center">{{ selectedProject.title }}</h2>
                    <p class="xl:text-lg text-base mt-4 text-center px-4">{{ selectedProject.description }}</p>
                </div>
                <button @click="closeModal"
                    class="absolute top-2 xl:top-6 right-2 xl:right-7 xl:w-11 bg-gray-200 text-black rounded-lg p-2 text-xl">✕</button>
            </div>
        </div>
    </section>
</template>


<script>
import axios from 'axios';

export default {
    name: "ProjectFeature",
    data() {
        return {
            featuredProjects: [],
            categories: [],
            showModal: false, // Controla a visibilidade do modal
            selectedImage: null,
            selectedProject: null // Armazena o projeto selecionado
        };
    },
    mounted() {
        this.fetchFeaturedProjects();
        this.fetchCategories();
    },
    methods: {
        async fetchFeaturedProjects() {
            try {
                const response = await axios.get('/api/featured-portfolios');
                this.featuredProjects = response.data;
            } catch (error) {
                console.error('Erro ao buscar os projetos:', error);
            }
        },
        async fetchCategories() {
            try {
                const response = await axios.get('/api/categories');
                this.categories = response.data;
            } catch (error) {
                console.error('Erro ao trazer as categorias:', error);
            }
        },
        getImageUrl(imagePath) {
            return `/storage/${imagePath}`;
        },
        getCategoryName(categoryId) {
            const category = this.categories.find(cat => cat.id === categoryId);
            return category ? category.name : 'Categoria desconhecida';
        },
        openModal(imageUrl, project) {
            this.selectedImage = imageUrl;
            this.selectedProject = project;
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
            this.selectedImage = null;
            this.selectedProject = null;
        }
    }
};

</script>

<style scoped>
.group:hover .group-hover\:opacity-100 {
    opacity: 1;
    border-radius: 5%;
}
</style>
