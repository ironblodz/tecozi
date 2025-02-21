<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage, Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
import { useDropzone } from "vue3-dropzone";

const { props } = usePage();
const portfolio = ref(props.portfolio);

const previewImage = ref(portfolio.value.main_image ? `/storage/${portfolio.value.main_image}` : null);

const gallery = ref(portfolio.value.gallery || []);
const galleryFiles = ref([]);

const categories = ref([]);


const handleGalleryChange = (event) => {
    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
        galleryFiles.value.push(files[i]); // Guarda os novos ficheiros
        gallery.value.push(URL.createObjectURL(files[i])); // Gera pré-visualização local
    }
    console.log("Novas imagens adicionadas:", galleryFiles.value);
};


// Função para atualizar a imagem principal
const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        portfolio.value.main_image = file;
        previewImage.value = URL.createObjectURL(file);
    }
};

// Atualizar portfólio no backend
const updatePortfolio = async () => {
    try {
        const formData = new FormData();
        formData.append('id', portfolio.value.id);
        formData.append('title', portfolio.value.title);
        formData.append('short_description', portfolio.value.short_description);
        formData.append('description', portfolio.value.description);
        formData.append('category_id', portfolio.value.category_id);

        // Apenas envia `main_image` se for uma nova imagem
        if (portfolio.value.main_image instanceof File) {
            formData.append('main_image', portfolio.value.main_image);
        }

        galleryFiles.value.forEach((file, index) => {
            formData.append(`gallery_images[${index}]`, file);
        });

        const response = await axios.post('/backoffice/portfolios/update', formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });

        if (response.data.data.main_image) {
            previewImage.value = response.data.data.main_image;
            console.log("Imagem principal atualizada:", previewImage.value);
        }

        if (response.data.data.gallery) {
            gallery.value = response.data.data.gallery;
            console.log("Galeria atualizada após upload:", gallery.value);
        }

        Toastify({ text: "Portfólio atualizado com sucesso!", backgroundColor: "green" }).showToast();

        setTimeout(() => {
            window.location = `/backoffice/portfolios`;
        }, 1500);

    } catch (error) {
        Toastify({ text: `Erro ao atualizar portfólio: ${error.message}`, backgroundColor: "red" }).showToast();
    }
};

const cancel = () => {
    window.location = `/backoffice/portfolios`;
};
onMounted(() => {
    axios.get('/backoffice/portfolios/categories')
        .then(response => {
            categories.value = response.data;
            console.log("Categorias carregadas:", categories.value);
        })
        .catch(error => console.error("Erro ao carregar categorias:", error));

    // Certifica-te de que a imagem principal e a galeria são carregadas corretamente
    if (portfolio.value) {
        previewImage.value = portfolio.value.main_image ? portfolio.value.main_image : null;
        console.log("Imagem principal carregada:", previewImage.value);

        if (portfolio.value.gallery && Array.isArray(portfolio.value.gallery)) {
            gallery.value = portfolio.value.gallery;
            console.log("Imagens da galeria carregadas:", gallery.value);
        } else {
            console.warn("Nenhuma imagem encontrada na galeria.");
        }
    }
});


</script>


<template>

    <Head title="Editar Projeto" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <a class="text-gray-800 flex-initial w-8" href="/backoffice/portfolios">
                    <i class="pi pi-arrow-circle-left text-xl"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 ml-2">Editar projeto</h2>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
                <div class="bg-primary-default text-white py-4 px-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-lg font-semibold">Edite as informações deste projeto</h2>
                </div>
                <form @submit.prevent="updatePortfolio" class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
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

                        <!-- Campo de categoria -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Categoria</label>
                            <select id="category_id" v-model="portfolio.category_id"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm">
                                <option value="" disabled selected>Selecione uma categoria</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                        </div>

                        <!-- Campo de imagem com pré-visualização -->
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Imagem
                                Principal</label>
                            <div class="flex items-center justify-center">
                                <div v-if="previewImage" class="w-2/5">
                                    <p class="text-gray-600 text-sm">Pré-visualização</p>
                                    <img :src="previewImage" alt="Preview"
                                        class="mt-2 w-32 h-32 object-cover rounded-md shadow">
                                </div>
                                <input id="image" type="file" @change="handleImageChange"
                                    class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                            </div>
                        </div>

                        <!-- Galeria de imagens -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Galeria de Fotos</label>
                            <div class="grid grid-cols-3 gap-4">
                                <div v-for="(img, index) in gallery" :key="index" class="relative">
                                    <img :src="img" class="w-full h-24 object-cover rounded-md shadow">
                                </div>
                            </div>
                            <input type="file" multiple @change="handleGalleryChange"
                                class="mt-2 border border-gray-300 rounded-lg px-4 py-2 w-full">
                        </div>


                        <div class="flex justify-end space-x-4 mt-6">
                            <button type="button" @click="cancel"
                                class="bg-secondary-default text-white px-4 py-2 rounded-md shadow-sm">Voltar</button>
                            <button type="submit"
                                class="bg-primary-default text-white px-4 py-2 rounded-md shadow-sm">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
