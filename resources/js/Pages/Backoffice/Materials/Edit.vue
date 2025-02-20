<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage, Head } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import Toastify from 'toastify-js';

import 'toastify-js/src/toastify.css';

// Propriedades e estado
const { props } = usePage();
const material = ref(props.material);
const previewImage = ref(material.value.photo ? `/storage/${material.value.photo}` : null);
const dropzoneRef = ref(null); // Referência ao Dropzone

// Atualizar imagem principal
const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        material.value.photo = file;
        previewImage.value = URL.createObjectURL(file); // Atualiza a pré-visualização com a nova imagem
    }
};

const updateMaterial = async () => {
    try {
        const formData = new FormData();

        // Necessário para Laravel interpretar corretamente o PUT via multipart/form-data
        formData.append('_method', 'PUT');

        // Adiciona apenas se existir valor
        if (material.value.title) {
            formData.append('title', material.value.title);
        }
        if (material.value.description) {
            formData.append('description', material.value.description);
        }
        if (material.value.photo instanceof File) {
            formData.append('photo', material.value.photo);
        }

        await axios.post(`/backoffice/materials/update/${material.value.id}`, formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });

        Toastify({ text: "Material atualizado com sucesso!" }).showToast();
        setTimeout(() => {
            window.location.href = "/backoffice/materials";
        }, 1500);
    } catch (error) {
        console.error(error.response?.data || error);
        Toastify({ text: `Erro ao atualizar material: ${error.message}` }).showToast();
    }
};



watch(() => material.value.photo, (newPhoto) => {
    if (newPhoto instanceof File) {
        previewImage.value = URL.createObjectURL(newPhoto);
    } else {
        previewImage.value = newPhoto ? `/storage/${newPhoto}` : null;
    }
});


// Cancelar e voltar
const cancel = () => {
    window.location = `/backoffice/materials`;
};

</script>

<template>

    <Head title="Editar Material" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <a class="text-gray-800 flex-initial w-8" href="/backoffice/materials">
                    <i class="pi pi-arrow-circle-left text-xl"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 ml-2">Editar Material</h2>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
                <div class="bg-primary-default text-white py-4 px-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-lg font-semibold">Edite as informações deste material</h2>
                </div>
                <form @submit.prevent="updateMaterial" class="p-6">
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
