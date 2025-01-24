<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage, Head } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import axios from 'axios';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
import Dropzone from 'dropzone';
import 'dropzone/dist/dropzone.css';

const { props } = usePage();

// Declaração de `category`
const category = ref({
    name: "",
    subtitle: "",
    description: "",
    img: null,
    existingGallery: [], // Imagens já existentes
    newGallery: []       // Novas imagens adicionadas
});

const galleryPreview = ref([]);
const errors = ref({});
const previewImage = ref(null);

// Referência para o elemento Dropzone
const galleryDropzone = ref(null);
let myDropzone = null;

// Indicador de submissão
const isSubmitting = ref(false);

// Função para limpar o formulário
const cancel = () => {
    window.location = `/backoffice/portfolios/categories`;
};

// Função para validar o formulário
const validateForm = () => {
    errors.value = {};
    let isValid = true;

    if (!category.value.name) {
        errors.value.name = "Name is required";
        isValid = false;
    }

    // Adicione outras validações conforme necessário

    return isValid;
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

// Função para criar ou atualizar a categoria
const createOrUpdateCategory = async () => {
    if (!validateForm()) return;

    isSubmitting.value = true;

    try {
        const formData = new FormData();

        // Não é necessário incluir o ID no FormData, pois está na URL
        // formData.append("id", props.category.id); // Remover se não for necessário

        formData.append("name", category.value.name);
        formData.append("subtitle", category.value.subtitle);
        formData.append("description", category.value.description);

        if (category.value.img instanceof File) { // Verifica se é um arquivo
            formData.append("img", category.value.img);
        }

        // Adicionar novas imagens à galeria
        if (category.value.newGallery.length) {
            category.value.newGallery.forEach((file) => {
                formData.append(`new_gallery[]`, file);
            });
        }

        // Indicar quais imagens existentes devem ser removidas
        const removedImages = category.value.existingGallery
            .filter(img => img.toRemove)
            .map(img => img.id);
        if (removedImages.length) {
            formData.append("removedGallery", JSON.stringify(removedImages));
        }

        console.log('Dados enviados:', {
            id: props.category ? props.category.id : null,
            name: category.value.name,
            subtitle: category.value.subtitle,
            description: category.value.description,
            img: category.value.img,
            newGallery: category.value.newGallery,
            removedGallery: removedImages,
        });

        // Utilize o método PUT para atualizações
        const response = await axios.put(
            `/backoffice/portfolios/categories/update/${props.category.id}`, // Endpoint de atualização
            formData,
            {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }
        );

        Toastify({ text: "Categoria atualizada com sucesso!", backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)" }).showToast();
        setTimeout(() => {
            window.location = `/backoffice/portfolios/categories`;
        }, 1500);
    } catch (error) {
        console.error("Erro ao salvar categoria:", error);
        Toastify({ text: "Erro ao salvar categoria.", backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)" }).showToast();
    } finally {
        isSubmitting.value = false;
    }
};


onMounted(() => {
    if (props.category) {
        category.value = {
            name: props.category.name || "",
            subtitle: props.category.subtitle || "",
            description: props.category.description || "",
            img: props.category.img ? `/storage/${props.category.img}` : null,
            existingGallery: props.category.photos || [],
            newGallery: []
        };

        // Carregar pré-visualizações das imagens existentes
        galleryPreview.value = category.value.existingGallery.map(photo => `/storage/${photo.photo_path}`);
    }

    // Configuração do Dropzone
    Dropzone.autoDiscover = false; // Evita que Dropzone automaticamente inicialize

    myDropzone = new Dropzone(galleryDropzone.value, {
        url: "/fake-url", // URL falsa já que vamos gerenciar o upload manualmente
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 10,
        maxFilesize: 5, // em MB
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        dictDefaultMessage: "Arraste e solte as imagens aqui ou clique para selecionar.",
    });

    // Adicionar imagens existentes ao Dropzone
    if (props.category && category.value.existingGallery.length) {
        category.value.existingGallery.forEach(photo => {
            // Criar um mock file para cada imagem existente
            const mockFile = {
                name: photo.photo_path.split('/').pop(), // Nome do arquivo
                size: 12345, // Tamanho fictício
                id: photo.id, // ID da imagem
                existing: true // Flag para identificar imagens existentes
            };

            // Adicionar o mock file ao Dropzone
            myDropzone.emit("addedfile", mockFile);
            myDropzone.emit("thumbnail", mockFile, `/storage/${photo.photo_path}`);
            myDropzone.emit("complete", mockFile);

            // Opcional: adicionar classe personalizada para diferenciação
            mockFile.previewElement.classList.add("dz-success", "dz-complete");
        });
    }

    // Evento quando um arquivo é adicionado
    myDropzone.on("addedfile", (file) => {
        if (!file.existing) {
            category.value.newGallery.push(file);
        }
    });

    // Evento quando um arquivo é removido
    myDropzone.on("removedfile", (file) => {
        if (file.existing) {
            // Marcar a imagem existente para remoção
            const existingImage = category.value.existingGallery.find(img => img.id === file.id);
            if (existingImage) {
                existingImage.toRemove = true;
                // Opcional: ocultar visualmente a imagem removida
                existingImage.removed = true;
            }
        } else {
            // Remover a nova imagem adicionada
            const index = category.value.newGallery.indexOf(file);
            if (index > -1) {
                category.value.newGallery.splice(index, 1);
            }
        }
    });

    // Prevenir que Dropzone envie arquivos automaticamente
    myDropzone.on("sending", function(file, xhr, formData) {
        xhr.abort(); // Impede o envio automático
    });
});

// Limpeza ao desmontar o componente
onBeforeUnmount(() => {
    if (myDropzone) {
        myDropzone.destroy();
    }
});
</script>

<template>
    <Head title="Criar/Editar Categoria" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <a class="text-gray-800 flex-initial w-8" href="/backoffice/portfolios/categories">
                    <i class="pi pi-arrow-circle-left text-xl"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 ml-2">
                    {{ props.category ? 'Editar Categoria' : 'Criar uma Nova Categoria' }}
                </h2>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
                <div class="bg-primary-default text-white py-4 px-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-lg font-semibold">
                        Insira a informação da {{ props.category ? 'categoria' : 'nova categoria' }}
                    </h2>
                </div>
                <form @submit.prevent="createOrUpdateCategory" class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input id="name" v-model="category.name" type="text"
                                :class="{ 'border-red-500': errors.name }"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm">
                            <p v-if="errors.name" class="text-red-600 text-sm">{{ errors.name }}</p>
                        </div>
                        <div>
                            <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtítulo</label>
                            <input id="subtitle" v-model="category.subtitle" type="text"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea id="description" v-model="category.description" rows="4"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm"></textarea>
                        </div>
                        <!-- Campo de imagem com pré-visualização -->
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Imagem Principal</label>
                            <div class="flex items-center justify-center">
                                <div v-if="previewImage || category.img" class="w-2/5">
                                    <p class="text-gray-600 text-sm">Pré-visualização</p>
                                    <img :src="previewImage || category.img" alt="Preview"
                                        class="mt-2 w-32 h-32 object-cover rounded-md shadow">
                                </div>
                                <input id="image" type="file" @change="handleImageChange"
                                    class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                            </div>
                        </div>
                        <div>
                            <label for="gallery" class="block text-sm font-medium text-gray-700">Galeria de Imagens</label>
                            <div id="gallery-dropzone" ref="galleryDropzone"
                                class="dropzone mt-1 border-2 border-dashed border-gray-300 rounded-md p-4">
                                <div class="dz-message">
                                    Arraste e solte as imagens aqui ou clique para selecionar.
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-4 mt-6">
                            <button type="button" @click="cancel"
                                class="bg-secondary-default text-white px-4 py-2 rounded-md shadow-sm hover:bg-gray-600">Voltar</button>
                            <button type="submit"
                                :disabled="isSubmitting"
                                class="bg-primary-default text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-700 disabled:opacity-50">
                                {{ isSubmitting ? 'Salvando...' : (props.category ? 'Atualizar' : 'Guardar') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
