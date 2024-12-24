<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage, Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
import Dropzone from 'dropzone';
import 'dropzone/dist/dropzone.css';

// Propriedades e estado
const { props } = usePage();
const portfolio = ref(props.portfolio);
const previewImage = ref(portfolio.value.main_image ? `/storage/${portfolio.value.main_image}` : null);
const dropzoneRef = ref(null); // Referência ao Dropzone

// Inicializar Dropzone
const initializeDropzone = () => {
    dropzoneRef.value = new Dropzone("#dropzone", {
        url: '/backoffice/portfolios/upload-image',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        dictRemoveFile: "Remover",
        init() {
            if (portfolio.value.images) {
                portfolio.value.images.forEach((image) => {
                    const mockFile = {
                        name: `Imagem ${image.id}`,
                        size: 12345,
                        id: image.id,
                        serverId: image.id
                    };

                    this.emit("addedfile", mockFile);
                    this.emit("thumbnail", mockFile, `/storage/${image.path}`);
                    this.emit("complete", mockFile);
                });
            }

            this.on("sending", (file, xhr, formData) => {
                formData.append('portfolioId', portfolio.value.id);
            });

            this.on("success", (file, response) => {
                if (response.imageId) {
                    file.serverId = response.imageId; // Registra o ID retornado pelo backend
                }
            });

            this.on("removedfile", async (file) => {
                if (file.serverId) {
                    try {
                        await axios.post('/backoffice/portfolios/remove-image', {
                            imageId: file.serverId,
                        });
                        Toastify({ text: "Imagem removida com sucesso!" }).showToast();
                    } catch (error) {
                        Toastify({ text: `Erro ao remover imagem: ${error.message}` }).showToast();
                    }
                }
            });
        },
    });
};

const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        portfolio.value.main_image = file;
        previewImage.value = URL.createObjectURL(file); // Atualiza a pré-visualização com a nova imagem
    }
};

// Atualizar portfólio
const updatePortfolio = async () => {
    try {
        const formData = new FormData();
        formData.append('id', portfolio.value.id);
        formData.append('title', portfolio.value.title);
        formData.append('short_description', portfolio.value.short_description);
        formData.append('description', portfolio.value.description);
        formData.append('category_id', portfolio.value.category_id); // Enviar categoria selecionada

        if (portfolio.value.main_image) {
            formData.append('main_image', portfolio.value.main_image);
        }

        await axios.post('/backoffice/portfolios/update', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        // Exibir mensagem de sucesso
        Toastify({ text: "Portfólio atualizado com sucesso!" }).showToast();

        setTimeout(() => {
            window.location = `/backoffice/portfolios`; // Redirecionar para a página de portfólios
        }, 1500);

    } catch (error) {
        Toastify({ text: `Erro ao atualizar portfólio: ${error.message}` }).showToast();
    }
};


const cancel = () => {
    window.location = `/backoffice/portfolios`;
};

// Inicializar Dropzone ao montar o componente
const categories = ref([]); // Lista de categorias

onMounted(() => {
    initializeDropzone();

    // Buscar categorias do backend
    axios.get('/backoffice/portfolios/categories')
        .then(response => {
            console.log('Categorias recebidas:', response.data); // Log para depuração
            categories.value = response.data;  // Atribui as categorias
        })
        .catch(error => {
            console.error("Erro ao carregar categorias:", error);
        });
});
</script>

<template>
    <Head title="Editar Projeto"/>
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
            <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">~
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
                        <div id="dropzone" class="dropzone mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Galeria de
                                Imagens</label>
                            <div class="dz-message">Arraste e solte imagens ou clique para fazer upload</div>
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
