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
                <div class="flex items-center mb-4">
                    <a href="#" @click="openModal" class="bg-secondary-default text-white px-4 py-2 rounded shadow">
                        Adicionar Novo Material
                    </a>
                </div>

                <!-- Campo de pesquisa -->
                <div class="mb-4">
                    <input type="text" v-model="searchQuery" placeholder="Pesquisar" @input="searchMaterials"
                        class="border border-gray-300 rounded px-4 py-2 w-full" />
                </div>

                <!-- Tabela de Materiais -->
                <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ordem</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(material, index) in filteredMaterials" :key="material.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ material.title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-4">
                                        <a href="#" @click="editMaterial(material)" class="text-primary-default flex items-center space-x-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7M4 4a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                                            </svg>
                                            <span>Editar</span>
                                        </a>
                                        <button @click="deleteMaterial(material.id)" class="text-secondary-default flex items-center space-x-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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

        <!-- Modal para Adicionar/Editar Material -->
        <Modal v-if="isModalOpen" @close="closeModal">
            <template #header>
                <h3 class="text-xl font-semibold">{{ modalTitle }}</h3>
            </template>
            <template #body>
                <form @submit.prevent="saveMaterial">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                        <input type="text" id="title" v-model="materialForm.title" class="border border-gray-300 rounded px-4 py-2 w-full" />
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                        <textarea id="description" v-model="materialForm.description" class="border border-gray-300 rounded px-4 py-2 w-full"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="photo" class="block text-sm font-medium text-gray-700">Foto</label>
                        <input type="file" id="photo" @change="handleFileUpload" class="border border-gray-300 rounded px-4 py-2 w-full" />
                    </div>
                    <button type="submit" class="bg-primary-default text-white px-4 py-2 rounded">Salvar</button>
                </form>
            </template>
        </Modal>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Modal from '@/components/Modal.vue'; // Supondo que você tenha um componente Modal

const materials = ref([]);
const searchQuery = ref('');
const isModalOpen = ref(false);
const modalTitle = ref('Adicionar Novo Material');
const materialForm = ref({ title: '', description: '', photo: null });
const currentMaterialId = ref(null);

const fetchMaterials = async () => {
    try {
        const response = await fetch('/api/materials');
        const data = await response.json();
        materials.value = data;
    } catch (error) {
        console.error('Erro ao carregar materiais:', error);
    }
};

const saveMaterial = async () => {
    const formData = new FormData();
    formData.append('title', materialForm.value.title);
    formData.append('description', materialForm.value.description);
    if (materialForm.value.photo) formData.append('photo', materialForm.value.photo);

    const url = currentMaterialId.value
        ? `/api/materials/${currentMaterialId.value}`
        : '/api/materials';

    const method = currentMaterialId.value ? 'PUT' : 'POST';

    try {
        const response = await fetch(url, {
            method,
            body: formData,
        });

        if (response.ok) {
            fetchMaterials();
            closeModal();
        } else {
            console.error('Erro ao salvar material');
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
    }
};

const editMaterial = (material) => {
    materialForm.value = { ...material };
    currentMaterialId.value = material.id;
    modalTitle.value = 'Editar Material';
    isModalOpen.value = true;
};

const deleteMaterial = async (id) => {
    try {
        const response = await fetch(`/api/materials/${id}`, {
            method: 'DELETE',
        });

        if (response.ok) {
            fetchMaterials();
        } else {
            console.error('Erro ao excluir material');
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
    }
};

const openModal = () => {
    materialForm.value = { title: '', description: '', photo: null };
    currentMaterialId.value = null;
    modalTitle.value = 'Adicionar Novo Material';
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const searchMaterials = () => {
    // Filtros de pesquisa, pode ser implementado aqui
    fetchMaterials();
};

onMounted(fetchMaterials);
</script>
