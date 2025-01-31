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
                        {{ props.category ? 'Editar' : 'Criar' }} Categoria
                    </h2>
                </div>

                <form @submit.prevent="createOrUpdateCategory" class="p-6">
                    <div class="space-y-4">
                        <!-- Nome -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nome
                            </label>
                            <input id="name" v-model="category.name" type="text"
                                   :class="{ 'border-red-500': errors.name }"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300
                                          rounded-md shadow-sm focus:outline-none focus:ring-blue-600
                                          focus:border-blue-600 sm:text-sm">
                            <p v-if="errors.name" class="text-red-600 text-sm">
                                {{ errors.name }}
                            </p>
                        </div>

                        <!-- Subtítulo -->
                        <div>
                            <label for="subtitle" class="block text-sm font-medium text-gray-700">
                                Subtítulo
                            </label>
                            <input id="subtitle" v-model="category.subtitle" type="text"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300
                                          rounded-md shadow-sm focus:outline-none focus:ring-blue-600
                                          focus:border-blue-600 sm:text-sm">
                        </div>

                        <!-- Descrição -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Descrição
                            </label>
                            <textarea id="description" v-model="category.description" rows="4"
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300
                                             rounded-md shadow-sm focus:outline-none focus:ring-blue-600
                                             focus:border-blue-600 sm:text-sm">
                            </textarea>
                        </div>

                        <!-- Imagem Principal (file input + preview) -->
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">
                                Imagem Principal
                            </label>
                            <div class="flex items-center space-x-4">
                                <div v-if="previewImage" class="w-32 h-32">
                                    <p class="text-gray-600 text-sm">Pré-visualização:</p>
                                    <img :src="previewImage" alt="Preview"
                                         class="mt-2 w-32 h-32 object-cover rounded-md shadow" />
                                </div>

                                <input id="image" type="file"
                                       @change="handleImageChange"
                                       class="border border-gray-300 rounded-lg px-4 py-2 w-full" />
                            </div>
                        </div>

                        <!-- Galeria de imagens (Dropzone) -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Galeria de Imagens
                            </label>
                            <form id="galleryDropzone" class="dropzone">
                                <div class="dz-message">
                                    Arraste e solte imagens ou clique para fazer upload
                                </div>
                            </form>
                        </div>

                        <div class="flex justify-end space-x-4 mt-6">
                            <button type="button"
                                    @click="cancel"
                                    class="bg-secondary-default text-white px-4 py-2 rounded-md shadow-sm hover:bg-gray-600">
                                Voltar
                            </button>
                            <button type="submit" :disabled="isSubmitting"
                                    class="bg-primary-default text-white px-4 py-2 rounded-md
                                           shadow-sm hover:bg-blue-700 disabled:opacity-50">
                                {{ isSubmitting ? 'Salvando...' : (props.category ? 'Atualizar' : 'Guardar') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage, Head } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import axios from 'axios';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
import Dropzone from 'dropzone';
import 'dropzone/dist/dropzone.css';

// Obtemos as props do Inertia
const { props } = usePage();

/**
 * Estado principal da categoria.
 */
const category = ref({
    id: props.category?.id ?? null,
    name: props.category?.name ?? "",
    subtitle: props.category?.subtitle ?? "",
    description: props.category?.description ?? "",
    mainImageId: props.category?.main_image_id ?? null,  // ID da imagem principal no servidor
    galleryImageIds: props.category?.photos?.map(p => p.id) ?? [],
});

/**
 * Para a imagem principal, vamos manter a lógica de input + preview.
 * Então, precisamos de 'previewImage' e 'handleImageChange'.
 */
const previewImage = ref(null);

// Se já existe uma imagem principal, podemos exibir no preview inicial
if (props.category?.img) {
    previewImage.value = `/storage/${props.category.img}`;
}

const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Exibe preview no front
        previewImage.value = URL.createObjectURL(file);
        // Armazenamos esse file em "category.value.mainImageFile"
        category.value.mainImageFile = file;
    } else {
        previewImage.value = null;
        category.value.mainImageFile = null;
    }
};

// Erros e estado de envio
const errors = ref({});
const isSubmitting = ref(false);

// Instância da Dropzone para a galeria
let dzGallery = null;

const cancel = () => {
    window.location = `/backoffice/portfolios/categories`;
};

const validateForm = () => {
    errors.value = {};
    let isValid = true;

    if (!category.value.name) {
        errors.value.name = "O nome é obrigatório.";
        isValid = false;
    }

    return isValid;
};

/**
 * Cria ou atualiza a categoria
 * (fazendo o upload do arquivo principal via FormData e usando IDs
 * das imagens da galeria já enviadas pelo Dropzone)
 */
const createOrUpdateCategory = async () => {
    if (!validateForm()) return;

    isSubmitting.value = true;

    try {
        const formData = new FormData();
        formData.append("name", category.value.name);
        formData.append("subtitle", category.value.subtitle);
        formData.append("description", category.value.description);

        // Se for edição ou criação, mas precisamos mandar o arquivo da imagem principal (caso tenha)
        if (category.value.mainImageFile) {
            formData.append("main_image_file", category.value.mainImageFile);
        } else if (category.value.mainImageId) {
            // Se já tinha uma imagem principal no backend
            formData.append("main_image_id", category.value.mainImageId);
        }

        // IDs das imagens da galeria (Dropzone)
        if (category.value.galleryImageIds.length > 0) {
            formData.append("gallery_ids", JSON.stringify(category.value.galleryImageIds));
        }

        // Decide se é edição ou criação
        if (category.value.id) {
            await axios.post(
                `/backoffice/portfolios/categories/update/${category.value.id}`,
                formData
            );
            Toastify({ text: "Categoria atualizada com sucesso!" }).showToast();
        } else {
            await axios.post("/backoffice/portfolios/categories/store", formData);
            Toastify({ text: "Categoria criada com sucesso!" }).showToast();
        }

        // Redireciona depois de breve pausa
        setTimeout(() => {
            window.location = `/backoffice/portfolios/categories`;
        }, 1500);
    } catch (error) {
        console.error(error);
        Toastify({
            text: `Erro ao salvar categoria: ${error.message}`,
            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
        }).showToast();
    } finally {
        isSubmitting.value = false;
    }
};

/**
 * Inicializa apenas o Dropzone da galeria (já que a imagem principal é via input/file)
 */
onMounted(() => {
    // Desabilitar autodiscover
    Dropzone.autoDiscover = false;

    dzGallery = new Dropzone("#galleryDropzone", {
        url: "/backoffice/portfolios/upload-image",
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        acceptedFiles: "image/*",
        addRemoveLinks: true,
        dictRemoveFile: "Remover",
        init() {
            // Carregar as fotos existentes como mockFile
            if (props.category?.photos?.length) {
                props.category.photos.forEach((photo) => {
                    const mockFile = {
                        name: `Foto-${photo.id}`,
                        size: 12345,
                        serverId: photo.id,
                    };
                    this.emit("addedfile", mockFile);
                    this.emit("thumbnail", mockFile, `/storage/${photo.path}`);
                    this.emit("complete", mockFile);
                    mockFile.previewElement.classList.add("dz-success", "dz-complete");
                });
            }

            this.on("sending", (file, xhr, formData) => {
                // Se já existir um ID de categoria, podemos enviar
                if (category.value.id) {
                    formData.append("categoryId", category.value.id);
                }
                // Indica que é galeria, se o backend precisar
                formData.append("isGallery", true);
            });

            this.on("success", (file, response) => {
                if (response.imageId) {
                    file.serverId = response.imageId;
                    category.value.galleryImageIds.push(response.imageId);
                    Toastify({ text: "Imagem de galeria enviada!" }).showToast();
                }
            });

            this.on("removedfile", async (file) => {
                if (file.serverId) {
                    try {
                        await axios.post("/backoffice/portfolios/categories/remove-image", {
                            imageId: file.serverId,
                        });
                        category.value.galleryImageIds = category.value.galleryImageIds.filter(
                            (id) => id !== file.serverId
                        );
                        Toastify({ text: "Imagem removida da galeria!" }).showToast();
                    } catch (error) {
                        Toastify({
                            text: `Erro ao remover da galeria: ${error.message}`,
                        }).showToast();
                    }
                }
            });
        },
    });
});

// Destrói a instância do Dropzone ao desmontar
onBeforeUnmount(() => {
    if (dzGallery) {
        dzGallery.destroy();
    }
});
</script>

<style scoped>
.dropzone {
    border: 2px dashed #999;
    padding: 20px;
    margin-bottom: 20px;
}
</style>
