<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

const { props } = usePage();

const category = ref({
    name: "",
    img: null // Armazena o arquivo da nova imagem
});

const errors = ref({});
const previewImage = ref(null); // Armazena a URL para a pré-visualização da imagem

// Função para redirecionar ao cancelar
const cancel = () => {
    window.location = `/backoffice/portfolios/categories`;
};

// Função para validar o formulário
const validateForm = () => {
    errors.value = {};
    if (!category.value.name) errors.value.name = "Name is required.";
    return Object.keys(errors.value).length === 0;
};

// Função para capturar a nova imagem e atualizar a pré-visualização
const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        category.value.img = file;
        previewImage.value = URL.createObjectURL(file); // Atualiza a pré-visualização com a nova imagem
    }
};

// Função para atualizar a categoria
const updateCategory = async () => {
    if (!validateForm()) return;

    const formData = new FormData();
    formData.append('id', category.value.id);
    formData.append('name', category.value.name);

    // Adiciona a nova imagem ao FormData, se ela for selecionada
    if (category.value.img) {
        formData.append('img', category.value.img);
    }

    try {
        const response = await axios.post(`/backoffice/portfolios/categories/update/`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        console.log('Category updated:', response.data);
        Toastify({text: "Categoria atualizada com sucesso!"}).showToast();
    } catch (error) {
        console.error('Error updating category:', error);
        Toastify({text: "" + error.message}).showToast();
    }
};

// Inicializa os dados da categoria ao montar o componente
onMounted(() => {
    category.value = props.category;
    previewImage.value =  `/storage/${props.category.img}`; // Define a imagem atual para pré-visualização inicial, caso exista
});

</script>

<template>
    <Head title="Editar Categoria" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <a class="text-gray-800 flex-initial w-8" href="/backoffice/portfolios/categories">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 ml-2">Atualizar Categoria</h2>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto p-4 bg-white shadow rounded-lg">
                <div class="bg-primary-default text-white py-4 px-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-lg font-semibold">Atualize as informações desta categoria</h2>
                </div>
                <div class="p-6">
                    <form @submit.prevent="updateCategory" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nome</label>
                            <input v-model="category.name" id="name" type="text" placeholder="Nome da categoria"
                                class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                        </div>

                        <!-- Campo de imagem com pré-visualização -->
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Imagem</label>
                            <div class="flex items-center justify-center">
                                <div v-if="previewImage" class="w-2/5">
                                    <p class="text-gray-600 text-sm">Pré-visualização</p>
                                    <img :src="previewImage" alt="Preview" class="mt-2 w-32 h-32 object-cover rounded-md shadow">
                                </div>
                                <input id="image" type="file" @change="handleImageChange"
                                    class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                            </div>
                        </div>


                        <div class="flex justify-end space-x-4">
                            <button type="button" @click="cancel"
                                class="bg-secondary-default text-white px-4 py-2 rounded-lg hover:bg-gray-600">Voltar</button>
                            <button type="submit"
                                class="bg-primary-default text-white px-4 py-2 rounded-lg hover:bg-blue-700">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.text-black {
    color: #000000;
}
</style>
