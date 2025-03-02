<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage, Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
import { useDropzone } from "vue3-dropzone";

const { props } = usePage();

const portfolio = ref({
    name: "",
    main_image: null, // campo para a imagem
    category_id: "" // campo para a categoria selecionada
});

const categories = ref([]); // Array para armazenar as categorias
const previewImage = ref(null);

const galleryFiles = ref([]); // Definir a variável galleryFiles
const previewGallery = ref([]); // Adicionando ref para a pré-visualização


const { getRootProps, getInputProps, isDragActive } = useDropzone({
    onDrop: (acceptedFiles) => {
        acceptedFiles.forEach(file => {
            // Verificar se é uma imagem ou vídeo
            if (file.type.startsWith("image/")) {
                galleryFiles.value.push(file);
                previewGallery.value.push({ type: "image", url: URL.createObjectURL(file) });
            } else if (file.type.startsWith("video/")) {
                galleryFiles.value.push(file);
                previewGallery.value.push({ type: "video", url: URL.createObjectURL(file) });
            } else {
                console.warn("Ficheiro não suportado:", file.type);
            }
        });
    },
    accept: "image/*,video/mp4,video/quicktime,video/x-msvideo,video/x-matroska,video/webm", // Adiciona suporte a vídeos
    multiple: true
});




// Função para limpar o formulário
const cancel = () => {
    window.location = `/backoffice/portfolios`
};

// Função para capturar a imagem principal
const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        portfolio.value.main_image = file;
        console.log("Imagem selecionada:", file);  // Verifique se o arquivo é capturado
        previewImage.value = URL.createObjectURL(file); // Atualiza a pré-visualização
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

        // Adicionar a imagem principal
        if (portfolio.value.main_image) {
            formData.append('main_image', portfolio.value.main_image);
        }

        // Adicionar as imagens e vídeos da galeria
        galleryFiles.value.forEach((file) => {
            formData.append('gallery_photos[]', file);
        });

        const response = await axios.post('/backoffice/portfolios/store', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        Toastify({ text: "Portfólio criado com sucesso!" }).showToast();
        setTimeout(() => {
            window.location = `/backoffice/portfolios`;
        }, 1500);

    } catch (error) {
        console.error('Erro ao criar portfólio:', error);
        Toastify({ text: error.message }).showToast();
    }
};


onMounted(() => {
    categories.value = props.categories;
})
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

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Galeria de Fotos</label>
                            <div v-bind="getRootProps()"
                                class="p-4 border-2 border-dashed border-gray-400 rounded-lg cursor-pointer text-center bg-gray-100">
                                <input v-bind="getInputProps()" />
                                <p v-if="isDragActive" class="text-blue-500">Solte as imagens aqui...</p>
                                <p v-else class="text-gray-600">Arraste e solte as imagens aqui ou clique para
                                    selecionar</p>
                            </div>


                            <!-- Lista de imagens carregadas -->
                            <div class="mt-4 grid grid-cols-3 gap-2">
                                <div v-for="(file, index) in previewGallery" :key="index" class="relative">
                                    <img v-if="file.type === 'image'" :src="file.url"
                                        class="w-full h-24 object-cover rounded-md shadow" />
                                    <video v-else-if="file.type === 'video'" :src="file.url"
                                        class="w-full h-24 object-cover rounded-md shadow" controls />
                                </div>
                            </div>


                        </div>

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
