<script setup>
import { ref, computed } from 'vue';
import { usePage, Head } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

// Página e props
const page = usePage();
const props = ref(page.props);

// Estado e dados
const materials = computed(() => props.value.materials || []);
const search = ref('');
const loading = ref(false);
const showModal = ref(false);
const materialToDelete = ref(null);

// Filtrar materiais com base na pesquisa
const filteredMaterials = computed(() => {
    if (!materials.value.length) return [];
    if (!search.value.trim()) return materials.value;

    return materials.value.filter(item =>
        item?.title?.toLowerCase().includes(search.value.trim().toLowerCase())
    );
});

// Confirmar exclusão
const confirmDelete = (materialId) => {
    materialToDelete.value = materialId;
    showModal.value = true;
};

// Fechar modal
const closeModal = () => {
    showModal.value = false;
    materialToDelete.value = null;
};

// Excluir material
const deleteMaterial = async () => {
    if (materialToDelete.value) {
        loading.value = true;
        try {
            await axios.delete(`/backoffice/materials/${materialToDelete.value}`);

            Toastify({ text: "Material excluído com sucesso!", duration: 3000 }).showToast();

            // Atualizar a lista localmente
            props.value.materials = props.value.materials.filter(
                (material) => material.id !== materialToDelete.value
            );
        } catch (error) {
            Toastify({ text: `Erro ao excluir: ${error.response?.data?.message || error.message}`, duration: 3000 }).showToast();
        } finally {
            loading.value = false;
            closeModal();
        }
    }
};

</script>

<template>
    <Head title="Materiais" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Materiais
            </h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Botão de adicionar material -->
                <div class="flex items-center mb-4">
                    <a :href="route('materials.create')" class="bg-secondary-default text-white px-4 py-2 rounded shadow">
                        Adicionar Material
                    </a>
                </div>

                <!-- Campo de pesquisa -->
                <div class="mb-4">
                    <input v-model="search" type="text" placeholder="Pesquisar" class="border border-gray-300 rounded px-4 py-2 w-full">
                </div>

                <!-- Loader -->
                <div v-if="loading" class="flex justify-center">
                    <svg class="animate-spin h-8 w-8 text-blue-700" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path d="M4 12a8 8 0 1 1 8 8V12h-8z"></path>
                    </svg>
                </div>

                <!-- Mensagem se não houver materiais -->
                <div v-if="!loading && filteredMaterials.length === 0" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    Não há materiais disponíveis
                </div>

                <!-- Tabela de dados -->
                <div v-if="!loading && filteredMaterials.length > 0" class="overflow-x-auto bg-white shadow-md rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagem</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="item in filteredMaterials" :key="item.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img :src="`/storage/` + item.photo + `?t=${new Date().getTime()}`" alt="Imagem do Material" class="w-16 h-16 object-cover rounded-md">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ item.title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ item.description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-4">
                                        <a :href="`/backoffice/materials/edit/${item.id}`" class="text-primary-default flex items-center space-x-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7M4 4a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path>
                                            </svg>
                                            <span>Editar</span>
                                        </a>
                                        <button @click.prevent="confirmDelete(item.id)" class="text-secondary-default flex items-center space-x-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            <span>Eliminar</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal para confirmação de exclusão -->
        <div v-if="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
                <h2 class="text-xl mb-4">Confirmar exclusão</h2>
                <p class="mb-4">Tem certeza que deseja excluir este material?</p>
                <div class="flex space-x-4">
                    <button @click="deleteMaterial" class="bg-red-500 text-white px-4 py-2 rounded-md">
                        Sim, excluir
                    </button>
                    <button @click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
