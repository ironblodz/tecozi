<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage, Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

const { props } = usePage();

const material = ref({
    title: "",
    description: "",
    photo: null // campo para a foto
});

const previewPhoto = ref(null);

// Função para limpar o formulário
const cancel = () => {
    window.location = `/backoffice/materials`
};

// Função para capturar a foto
const handlePhotoChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        material.value.photo = file;
        console.log("Foto selecionada:", file);
        previewPhoto.value = URL.createObjectURL(file);
    } else {
        console.warn("Nenhuma foto selecionada");
    }
};

// Função para criar o material
const createMaterial = async () => {
    try {
        const formData = new FormData();
        formData.append('title', material.value.title);
        formData.append('description', material.value.description);

        // Adicione a foto ao FormData apenas se ela for fornecida
        if (material.value.photo) {
            formData.append('photo', material.value.photo);
        }

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


onMounted(() => {
    // Carregar dados necessários, se houver, no momento da montagem
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

                        <!-- Campo de foto com pré-visualização -->
                        <div class="mb-4">
                            <label for="photo" class="block text-gray-700 text-sm font-bold mb-2">Foto Principal</label>
                            <div class="flex items-center justify-center">
                                <!-- Pré-visualização da foto -->
                                <div v-if="previewPhoto" class="w-2/5">
                                    <p class="text-gray-600 text-sm">Pré-view:</p>
                                    <img :src="previewPhoto" alt="Preview"
                                        class="mt-2 w-32 h-32 object-cover rounded-md shadow">
                                </div>
                                <input id="photo" type="file" @change="handlePhotoChange"
                                    class="border border-gray-300 rounded-lg px-4 py-2 w-full">
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
