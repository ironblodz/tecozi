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

                <form @submit.prevent="updateCategory" class="p-6">
                    <div class="space-y-4">
                        <!-- Nome -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nome
                            </label>
                            <input id="name" v-model="category.name" type="text"
                                :class="{ 'border-red-500': errors.name }" class="mt-1 block w-full px-3 py-2 border border-gray-300
                                          rounded-md shadow-sm focus:outline-none focus:ring-blue-600
                                          focus:border-blue-600 sm:text-sm">
                            <p v-if="errors.name" class="text-red-600 text-sm">
                                {{ errors.name }}
                            </p>
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

                                <input id="image" type="file" @change="handleImageChange"
                                    class="border border-gray-300 rounded-lg px-4 py-2 w-full" />
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 mt-6">
                            <button type="button" @click="cancel"
                                class="bg-secondary-default text-white px-4 py-2 rounded-md shadow-sm hover:bg-gray-600">
                                Voltar
                            </button>
                            <button type="submit" :disabled="isSubmitting" class="bg-primary-default text-white px-4 py-2 rounded-md
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
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

const { props } = usePage();

const category = ref({
    id: props.category?.id ?? null,
    name: props.category?.name ?? "",
    reference: props.category?.reference ?? "",
    label: props.category?.label ?? "",
    archived: props.category?.archived ?? false,
    visible_on_portfolio: props.category?.visible_on_portfolio ?? false,
    img: props.category?.img ?? null, // URL da imagem existente
});

const previewImage = ref(null);
const selectedImage = ref(null);

if (category.value.img) {
    previewImage.value = category.value.img.startsWith("http")
        ? category.value.img
        : `/storage/${category.value.img}`;
}


const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        previewImage.value = URL.createObjectURL(file);
        selectedImage.value = file;
    } else {
        // Se o utilizador remover a seleção, mantém a imagem antiga
        previewImage.value = category.value.img;
        selectedImage.value = null;
    }
};


const errors = ref({});
const isSubmitting = ref(false);

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
const updateCategory = async () => {
    if (!validateForm()) return;
    isSubmitting.value = true;

    try {
        const formData = new FormData();
        formData.append("name", category.value.name);
        formData.append("reference", category.value.reference);
        formData.append("label", category.value.label);
        formData.append("archived", category.value.archived ? 1 : 0);
        formData.append("visible_on_portfolio", category.value.visible_on_portfolio ? 1 : 0);

        if (selectedImage.value) {
            formData.append("img", selectedImage.value);
        }

        await axios.post(`/backoffice/portfolios/categories/${category.value.id}/update`, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });

        Toastify({ text: "Categoria atualizada com sucesso!" }).showToast();

        setTimeout(() => {
            window.location = `/backoffice/portfolios/categories`;
        }, 1500);
    } catch (error) {
        console.error(error);
        let errorMessage = 'Erro ao atualizar categoria.';
        if (error.response && error.response.data && error.response.data.message) {
            errorMessage = error.response.data.message;
        }
        Toastify({
            text: `Erro ao atualizar categoria: ${errorMessage}`,
            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
        }).showToast();
    } finally {
        isSubmitting.value = false;
    }
};

</script>
