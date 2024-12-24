<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage, Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

const { props } = usePage();

const portfolio = ref({
    name: "",
    main_image: null, // campo para a imagem
    category_id: "" // campo para a categoria selecionada
});

const categories = ref([]); // Array para armazenar as categorias
const previewImage = ref(null);

// Função para limpar o formulário
const cancel = () => {
    window.location = `/backoffice/portfolios`
};

// Função para capturar a imagem
const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        portfolio.value.main_image = file;
        console.log("Imagem selecionada:", file);  // Verifique se o arquivo é capturado
        previewImage.value = URL.createObjectURL(file);
    } else {
        console.warn("Nenhuma imagem selecionada");
    }
};

// Função para criar o portfolio
const createPortfolio = async () => {
    try {
        const formData = new FormData();
        formData.append('title', portfolio.value.title);
        formData.append('short_description', portfolio.value.short_description);
        formData.append('description', portfolio.value.description);
        formData.append('category_id', portfolio.value.category_id);

        // Adicione a imagem ao FormData, se presente
        if (portfolio.value.main_image) {
            formData.append('main_image', portfolio.value.main_image);
        }

        const response = await axios.post('/backoffice/portfolios/store', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        Toastify({ text: "Portfólio criado com sucesso!" }).showToast();

        setTimeout(() => {
            window.location = `/backoffice/portfolios`; // Redirecionar para a página de portfólios
        }, 1500);

    } catch (error) {
        console.error('Erro ao criar portfolio:', error);
        Toastify({ text: "" + error.message }).showToast();
    }
};

onMounted(() => {
    categories.value = props.categories;

    if (props.portfolio && props.portfolio.main_image) {
        previewImage.value = props.portfolio.main_image;
    }
});
</script>

<template>
    <Head title="Criar Portfólio" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <a class="text-gray-800 flex-inicial w-8" href="/backoffice/portfolios">
                    <i class="pi pi-arrow-circle-left text-xl"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 ml-2">Criar um novo projeto</h2>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
                <div class="bg-primary-default text-white py-4 px-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-lg font-semibold">Insira a informação do novo projeto</h2>
                </div>
                <form @submit.prevent="createPortfolio" class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input id="title" v-model="portfolio.title" type="text"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm">
                        </div>

                        <div>
                            <label for="short_description" class="block text-sm font-medium text-gray-700">Descrição
                                curta</label>
                            <input id="short_description" v-model="portfolio.short_description" type="text"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea v-model="portfolio.description" id="description"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm"></textarea>
                        </div>

                        <!-- Campo de categoria como Select -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Categoria</label>
                            <select id="category_id" v-model="portfolio.category_id"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm">
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{
                                    category.name
                                    }}</option>
                            </select>
                        </div>

                        <!-- Campo de imagem com pré-visualização -->
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Imagem
                                Principal</label>
                            <div class="flex items-center justify-center">
                                <!-- Pré-visualização da imagem -->
                                <div v-if="previewImage" class="w-2/5">
                                    <p class="text-gray-600 text-sm">Pré-view:</p>
                                    <img :src="previewImage" alt="Preview"
                                        class="mt-2 w-32 h-32 object-cover rounded-md shadow">
                                </div>
                                <input id="image" type="file" @change="handleImageChange"
                                    class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                            </div>
                        </div>

                        <p>As imagens da galeria só poderão ser adicionadas após o portfólio ser criado.</p>

                        <div class="flex justify-end space-x-4 mt-6">
                            <button type="button" @click="cancel"
                                class="bg-secondary-default text-white px-4 py-2 rounded-md shadow-sm hover:bg-gray-600">Voltar</button>
                            <button type="submit"
                                class="bg-primary-default text-white px-4 py-2 rounded-md shadow-sm ">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
