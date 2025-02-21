<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage, Head } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
import { useDropzone } from "vue3-dropzone";

const { props } = usePage();

const material = ref({
    title: "",
    description: "",
    photo: null // campo para a foto principal
});

const previewPhoto = ref(null);
const previewGallery = ref([]);
const galleryFiles = ref([]); // Armazena os arquivos

const { getRootProps, getInputProps, isDragActive } = useDropzone({
    onDrop: (acceptedFiles) => {
        acceptedFiles.forEach(file => {
            galleryFiles.value.push(file);
            previewGallery.value.push(URL.createObjectURL(file)); // Gerar URL para pré-visualização
        });
    },
    accept: "image/*",
    multiple: true
});



// Função para limpar o formulário
const cancel = () => {
    window.location = `/backoffice/materials`
};

// Função para capturar a foto principal
const handlePhotoChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        material.value.photo = file;
        previewPhoto.value = URL.createObjectURL(file);
    }
};

// Função para criar o material
const createMaterial = async () => {
    try {
        const formData = new FormData();
        formData.append('title', material.value.title);
        formData.append('description', material.value.description);

        // Adicionar foto principal
        if (material.value.photo) {
            formData.append('photo', material.value.photo);
        }

        // Adicionar fotos da galeria ao FormData
        galleryFiles.value.forEach((file) => {
            formData.append('gallery_photos[]', file);
        });

        const response = await axios.post('/backoffice/materials/store', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        Toastify({ text: "Material criado com sucesso!" }).showToast();

        setTimeout(() => {
            window.location = `/backoffice/materials`;
        }, 1500);

    } catch (error) {
        console.error('Erro ao criar material:', error.response.data);
        Toastify({ text: "Erro: " + error.response.data.error }).showToast();
    }
};

onUnmounted(() => {
    previewGallery.value.forEach(url => URL.revokeObjectURL(url));
});
</script>
<template>

    <Head title="Criar Material" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <a class="text-gray-800 flex-inicial w-8" href="/backoffice/materials">
                    <i class="pi pi-arrow-circle-left text-xl"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 ml-2">Criar um novo material</h2>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
                <div class="bg-primary-default text-white py-4 px-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-lg font-semibold">Insira a informação do novo material</h2>
                </div>
                <form @submit.prevent="createMaterial" class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                            <input id="title" v-model="material.title" type="text"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea v-model="material.description" id="description"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm"></textarea>
                        </div>

                        <!-- Foto principal -->
                        <div class="mb-4">
                            <label for="photo" class="block text-gray-700 text-sm font-bold mb-2">Foto Principal</label>
                            <div class="flex items-center justify-center">
                                <div v-if="previewPhoto" class="w-2/5">
                                    <p class="text-gray-600 text-sm">Pré-visualização:</p>
                                    <img :src="previewPhoto" alt="Preview"
                                        class="mt-2 w-32 h-32 object-cover rounded-md shadow">
                                </div>
                                <input id="photo" type="file" @change="handlePhotoChange"
                                    class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                            </div>
                        </div>

                        <!-- Dropzone para múltiplas imagens -->
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
                                <div v-for="(src, index) in previewGallery" :key="index" class="relative">
                                    <img v-if="src" :src="src" class="w-full h-24 object-cover rounded-md shadow" />
                                </div>
                            </div>

                        </div>

                        <div class="flex justify-end space-x-4 mt-6">
                            <button type="button" @click="cancel"
                                class="bg-secondary-default text-white px-4 py-2 rounded-md shadow-sm hover:bg-gray-600">Voltar</button>
                            <button type="submit"
                                class="bg-primary-default text-white px-4 py-2 rounded-md shadow-sm">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
