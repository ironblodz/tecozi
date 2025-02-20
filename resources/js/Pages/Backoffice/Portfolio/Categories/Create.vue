<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage, Head } from '@inertiajs/vue3';
import { ref, onMounted} from 'vue';
import axios from 'axios';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
import 'dropzone/dist/dropzone.css';

const { props } = usePage();

// Declaração de `category`
const category = ref({
    name: "",
    img: null,
});

const galleryPreview = ref([]);
const errors = ref({});
const previewImage = ref(null);

// Referência para o elemento Dropzone
const galleryDropzone = ref(null);
let myDropzone = null;

// Função para limpar o formulário
const cancel = () => {
    window.location = `/backoffice/portfolios/categories`;
};

// Função para validar o formulário
const validateForm = () => {
    errors.value = {};
    if (!category.value.name) errors.value.name = "Name is required";
    return Object.keys(errors.value).length === 0;
};

// Função para capturar a imagem
const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];
        if (!allowedTypes.includes(file.type)) {
            alert('Tipo de arquivo não suportado! Apenas imagens são permitidas.');
            return;
        }
        category.value.img = file;
        previewImage.value = URL.createObjectURL(file);
    }
};

// Função para criar a categoria
const createCategory = async () => {
    if (!validateForm()) return;

    try {
        const formData = new FormData();
        formData.append("name", category.value.name);


        if (category.value.img) {
            formData.append("img", category.value.img);
        }

        console.log('Dados enviados:', {
            name: category.value.name,
            img: category.value.img,
        });

        const response = await axios.post(
            "/backoffice/portfolios/categories/store",
            formData,
            {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }
        );

        Toastify({ text: "Categoria criada com sucesso!" }).showToast();
        setTimeout(() => {
            window.location = `/backoffice/portfolios/categories`;
        }, 1500);
    } catch (error) {
        console.error("Erro ao criar categoria:", error);
        Toastify({ text: "Erro ao criar categoria." }).showToast();
    }
};

onMounted(() => {
    if (props.category) {
        category.value = {
            name: props.category.name || "",
            img: props.category.img ? `/storage/${props.category.img}` : null,
        };
    }
});
</script>


<template>

    <Head title="Criar Categoria" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <a class="text-gray-800 flex-initial w-8" href="/backoffice/portfolios/categories">
                    <i class="pi pi-arrow-circle-left text-xl"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 ml-2">Criar uma nova categoria</h2>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
                <div class="bg-primary-default text-white py-4 px-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-lg font-semibold">Insira a informação da nova categoria</h2>
                </div>
                <form @submit.prevent="createCategory" class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input id="name" v-model="category.name" type="text"
                                :class="{ 'border-red-500': errors.name }"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm">
                            <p v-if="errors.name" class="text-red-600 text-sm">{{ errors.name }}</p>
                        </div>
                        <!-- Campo de imagem com pré-visualização -->
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Imagem</label>
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
                                class="bg-secondary-default text-white px-4 py-2 rounded-md shadow-sm hover:bg-gray-600">Voltar</button>
                            <button type="submit"
                                class="bg-primary-default text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-700">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
