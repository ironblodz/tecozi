<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import { Head, usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";

const { props } = usePage();

const category = ref({
    name: "",
    subtitle: "",
    description: "",
    img: null, // Armazena a imagem de capa
    gallery: [], // Armazena os arquivos da galeria
});
const galleryPreview = ref([]);

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

const handleGalleryChange = (event) => {
    const files = event.target.files;
    const newFiles = Array.from(files);

    // Adiciona novos arquivos à galeria
    category.value.gallery.push(...newFiles);

    // Atualiza o preview com os novos arquivos adicionados
    galleryPreview.value.push(...newFiles.map((file) => URL.createObjectURL(file)));
};

const removeImageFromGallery = (index) => {
    // Remove o arquivo da galeria
    category.value.gallery.splice(index, 1);
    // Remove a visualização correspondente
    galleryPreview.value.splice(index, 1);
};


// Função para excluir imagens já salvas na galeria no servidor
const deleteImageFromServer = async (imageId, index) => {
    if (!imageId) {
        Toastify({ text: "Imagem inválida ou já excluída." }).showToast();
        return;
    }

    try {
        await axios.post(`/backoffice/portfolios/categories/delete-gallery-image`, { id: imageId });
        Toastify({ text: "Imagem excluída com sucesso!" }).showToast();

        // Remove do preview as imagens salvas no servidor
        props.category.gallery.splice(index, 1);
        galleryPreview.value.splice(index, 1);
    } catch (error) {
        console.error("Erro ao excluir imagem:", error);
        Toastify({ text: "Erro ao excluir imagem." }).showToast();
    }
};

// Função para atualizar a categoria
const updateCategory = async () => {
    if (!validateForm()) return;

    const formData = new FormData();
    formData.append("id", category.value.id);
    formData.append("name", category.value.name);
    formData.append("subtitle", category.value.subtitle);
    formData.append("description", category.value.description);

    if (category.value.img) {
        formData.append("img", category.value.img);
    }

    if (category.value.gallery.length) {
        category.value.gallery.forEach((file, index) => {
            formData.append(`gallery[${index}]`, file);
        });
    }

    try {
        const response = await axios.post(
            `/backoffice/portfolios/categories/update/`,
            formData,
            {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            }
        );
        console.log("Category updated:", response.data);

        // Exibe a mensagem de sucesso
        Toastify({ text: "Categoria atualizada com sucesso!" }).showToast();

        // Redireciona para a página de índice após 1,5 segundos
        setTimeout(() => {
            window.location = `/backoffice/portfolios/categories`;
        }, 1500);
    } catch (error) {
        console.error("Error updating category:", error);
        Toastify({
            text: "Erro ao atualizar a categoria: " + error.message,
        }).showToast();
    }
};

onMounted(() => {
    // Preenche os dados da categoria
    category.value = { ...props.category, gallery: props.category.gallery || [] };

    // Define a imagem de capa
    previewImage.value = props.category.img ? `/storage/${props.category.img}` : null;

    // Define as imagens da galeria
    galleryPreview.value = props.category.gallery
        ? props.category.gallery.map((image) => image.path ? `/storage/${image.path}` : null).filter(Boolean)
        : [];
});

</script>

<template>

    <Head title="Editar Categoria" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <a class="text-gray-800 flex-initial w-8" href="/backoffice/portfolios/categories">
                    <i class="pi pi-arrow-circle-left text-xl"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 ml-2">
                    Atualizar categorias
                </h2>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
                <div class="bg-primary-default text-white py-4 px-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-lg font-semibold">
                        Atualize as informações desta categoria
                    </h2>
                </div>
                <form @submit.prevent="updateCategory" enctype="multipart/form-data">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nome</label>
                            <input v-model="category.name" id="name" type="text" placeholder="Nome da categoria"
                                class="border border-gray-300 rounded-lg px-4 py-2 w-full" />
                        </div>
                        <div>
                            <label for="subtitle" class="block text-gray-700 text-sm font-bold mb-2">Subtítulo</label>
                            <input v-model="category.subtitle" id="subtitle" type="text"
                                placeholder="Subtítulo da categoria"
                                class="border border-gray-300 rounded-lg px-4 py-2 w-full" />
                        </div>

                        <div>
                            <label for="description"
                                class="block text-gray-700 text-sm font-bold mb-2">Descrição</label>
                            <textarea v-model="category.description" id="description" rows="4"
                                placeholder="Descrição da categoria"
                                class="border border-gray-300 rounded-lg px-4 py-2 w-full"></textarea>
                        </div>

                        <!-- Campo de imagem com pré-visualização -->
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Imagem</label>
                            <div class="flex items-center justify-center">
                                <div v-if="previewImage" class="w-2/5">
                                    <p class="text-gray-600 text-sm">
                                        Pré-visualização
                                    </p>
                                    <img :src="previewImage" alt="Preview"
                                        class="mt-2 w-32 h-32 object-cover rounded-md shadow" />
                                </div>
                                <input id="image" type="file" @change="handleImageChange"
                                    class="border border-gray-300 rounded-lg px-4 py-2 w-full" />
                            </div>
                        </div>
                        <div>
                            <label for="gallery" class="block text-sm font-medium text-gray-700">Galeria de
                                Imagens</label>
                            <input id="gallery" type="file" multiple @change="handleGalleryChange"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm">

                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <!-- Imagens existentes salvas no servidor -->
                                <div v-for="(image, index) in props.category.gallery" :key="image.id" class="relative">
                                    <img :src="`/storage/${image.path}`" alt="Preview"
                                        class="w-32 h-32 object-cover rounded-md shadow">
                                    <!-- Botão para excluir imagens salvas -->
                                    <button @click.prevent="deleteImageFromServer(image.id, index)"
                                        class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full hover:bg-red-700">
                                        &times;
                                    </button>
                                </div>

                                <!-- Novas imagens adicionadas -->
                                <div v-for="(image, index) in galleryPreview" :key="'new-' + index" class="relative">
                                    <img :src="image" alt="Preview" class="w-32 h-32 object-cover rounded-md shadow">
                                    <!-- Botão para remover novas imagens adicionadas -->
                                    <button @click.prevent="removeImageFromGallery(index)"
                                        class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full hover:bg-red-700">
                                        &times;
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 mt-6">
                            <button type="button" @click="cancel"
                                class="bg-secondary-default text-white px-4 py-2 rounded-md shadow-sm hover:bg-gray-600">
                                Voltar
                            </button>
                            <button type="submit"
                                class="bg-primary-default text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-700">
                                Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
