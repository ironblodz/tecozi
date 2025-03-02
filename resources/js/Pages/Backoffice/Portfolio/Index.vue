<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { usePage, Head } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import draggable from 'vuedraggable';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

// Página e props
const page = usePage();
const props = ref(page.props);

// Estado e dados
const portfolios = ref(props.value?.portfolios || []);
const categories = ref([]); // Lista de categorias
const search = ref('');
const loading = ref(false);
const showModal = ref(false);
const portfolioToDelete = ref(null);

// Filtrar portfolios com base na pesquisa e garantir ordenação correta
const filteredPortfolio = computed(() => {
    if (categories.value.length === 0 || portfolios.value.length === 0) {
        return [];
    }

    return portfolios.value
        .filter(portfolio => {
            return !search.value || portfolio.title.toLowerCase().includes(search.value.trim().toLowerCase());
        });
});


const updateOrder = async () => {
    const updatedOrder = portfolios.value.map((portfolio, index) => ({
        id: portfolio.id,
        order: index + 1
    }));

    console.log("Ordem enviada para o backend:", updatedOrder);

    try {
        await axios.post('/backoffice/portfolios/update-order', { portfolios: updatedOrder });

        // Atualizar localmente para refletir a nova ordem
        portfolios.value.forEach((portfolio, index) => {
            portfolio.order = index + 1;
        });

        Toastify({ text: "Ordem atualizada com sucesso!", duration: 3000 }).showToast();
    } catch (error) {
        Toastify({ text: `Erro ao atualizar ordem: ${error.message}`, duration: 3000 }).showToast();
    }
};



// Atualiza os portfólios do backend
const fetchPortfolios = async () => {
    try {
        const response = await axios.get('/api/portfolios');
        portfolios.value = response.data.sort((a, b) => a.order - b.order);
    } catch (error) {
        console.error("Erro ao buscar portfólios:", error);
    }
};



// Funções existentes
const toggleHighlight = async (portfolioId) => {
    try {
        await axios.post('/backoffice/portfolios/toggle-highlight', { id: portfolioId });
        const portfolio = portfolios.value.find(item => item.id === portfolioId);
        if (portfolio) {
            portfolio.highlighted = !portfolio.highlighted;
        }
        Toastify({ text: "Status atualizado com sucesso!" }).showToast();
    } catch (error) {
        Toastify({ text: `Erro: ${error.message}` }).showToast();
    }
};

const confirmDelete = (portfolioId) => {
    portfolioToDelete.value = portfolioId;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    portfolioToDelete.value = null;
};

const toggleArchive = async (portfolioId) => {
    try {
        const response = await axios.post('/backoffice/portfolios/toggle-archive', { id: portfolioId });
        const portfolio = portfolios.value.find(item => item.id === portfolioId);
        if (portfolio) {
            portfolio.archived = !portfolio.archived;
        }
        Toastify({ text: response.data.message }).showToast();
    } catch (error) {
        Toastify({ text: `Erro: ${error.message}` }).showToast();
    }
};

const deletePortfolio = async () => {
    if (!portfolioToDelete.value) return;

    loading.value = true;

    try {
        await axios.delete('/backoffice/portfolios/delete', {
            data: { id: portfolioToDelete.value }
        });

        Toastify({ text: "Portfólio excluído com sucesso!", duration: 3000 }).showToast();

        // Remove da lista sem precisar de recarregar a página
        portfolios.value = portfolios.value.filter(portfolio => portfolio.id !== portfolioToDelete.value);

    } catch (error) {
        Toastify({ text: `Erro: ${error.response?.data?.message || error.message}`, duration: 3000 }).showToast();
    } finally {
        loading.value = false;
        closeModal();
    }
};

onMounted(async () => {
    try {
        // Carregar categorias primeiro
        const categoryResponse = await axios.get('/backoffice/portfolios/categories');
        if (Array.isArray(categoryResponse.data)) {
            categories.value = categoryResponse.data;
            console.log("Categorias carregadas:", categories.value);
        } else {
            console.error("Erro: Categorias não são um array!");
            categories.value = [];
        }

        // Agora carrega os portfólios
        const portfolioResponse = await axios.get('/api/portfolios');
        portfolios.value = portfolioResponse.data.map(portfolio => {
            // Associar a categoria correta
            const category = categories.value.find(c => c.id == portfolio.category_id);
            return {
                ...portfolio,
                category_name: category ? category.name : 'Categoria não encontrada'
            };
        });

        console.log("Portfólios carregados:", portfolios.value);
    } catch (error) {
        console.error("Erro ao carregar dados:", error);
    }
});


</script>


<template>

    <Head title="Portfólios" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Portfólio</h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center mb-4">
                    <a :href="route('portfolio.create')"
                        class="bg-secondary-default text-white px-4 py-2 rounded shadow">
                        Adicionar Projeto
                    </a>
                </div>

                <div class="mb-4">
                    <input v-model="search" type="text" placeholder="Pesquisar"
                        class="border border-gray-300 rounded px-4 py-2 w-full">
                </div>

                <div v-if="loading" class="flex justify-center">
                    <svg class="animate-spin h-8 w-8 text-blue-700" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path d="M4 12a8 8 0 1 1 8 8V12h-8z"></path>
                    </svg>
                </div>

                <div v-if="!loading && filteredPortfolio.length === 0"
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    Não há portfólios disponíveis
                </div>

                <div v-if="!loading && filteredPortfolio.length > 0"
                    class="overflow-x-auto bg-white shadow-md rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ordem</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Imagem</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Galeria</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoria
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                            </tr>
                        </thead>
                        <draggable v-model="portfolios" tag="tbody" item-key="id" :disabled="loading"
                            @end="updateOrder">
                            <template #item="{ element }">
                                <tr class="cursor-move">
                                    <td class="px-6 py-4 whitespace-nowrap">☰ {{ element.order }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img :src="`/storage/${element.main_image}`"
                                            class="w-16 h-16 object-cover rounded-md">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-wrap gap-2">
                                            <div v-for="file in element.gallery" :key="file.url" class="w-16 h-16">
                                                <!-- Se for imagem, exibir normalmente -->
                                                <img v-if="file.type === 'image'" :src="file.url"
                                                    class="object-cover w-full h-full rounded-md">

                                                <!-- Se for vídeo, exibir com controles -->
                                                <video v-else-if="file.type === 'video'" :src="file.url"
                                                    class="object-cover w-full h-full rounded-md" controls />
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-black">{{ element.category_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ element.title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a :href="`/backoffice/portfolios/edit/${element.id}`"
                                            class="text-primary-default flex items-center space-x-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7M4 4a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                                            </svg>
                                            <span>Editar</span>
                                        </a>
                                        <button @click="toggleHighlight(element.id)"
                                            :class="element.highlighted ? 'text-secondary-default' : 'text-primary-default'"
                                            class="flex items-center space-x-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    :d="element.highlighted
                                                        ? 'M3 12l2-2m0 0l7-7 7 7M13 5v6h6'
                                                        : 'M12 4v16m8-8H4'" />
                                            </svg>
                                            <span>
                                                {{ element.highlighted ? "Não Destacar" : "Destacar" }}
                                            </span>
                                        </button>
                                        <button @click.prevent="toggleArchive(element.id)"
                                            :class="element.archived ? 'text-green-500' : 'text-yellow-500'"
                                            class="flex items-center space-x-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    :d="element.archived
                                                        ? 'M3 12l2-2m0 0l7-7 7 7M13 5v6h6'
                                                        : 'M12 4v16m8-8H4'" />
                                            </svg>
                                            <span>
                                                {{ element.archived ? "Desarquivar" : "Arquivar" }}
                                            </span>
                                        </button>
                                        <button @click.prevent="confirmDelete(element.id)"
                                            class="text-secondary-default flex items-center space-x-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <span>Eliminar</span>
                                        </button>

                                    </td>
                                </tr>
                            </template>
                        </draggable>
                    </table>
                </div>
            </div>
        </div>
        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-gray-500 bg-opacity-75 absolute inset-0"></div>
            <div class="bg-white rounded-lg shadow-lg p-6 relative z-10">
                <h3 class="text-lg font-semibold text-gray-900">
                    Eliminar Portfólio
                </h3>
                <p class="mt-2 text-sm text-gray-700">
                    Tem certeza de que deseja excluir este portfólio? Esta ação
                    não pode ser desfeita.
                </p>
                <div class="mt-4 flex justify-end space-x-4">
                    <button @click="deletePortfolio"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                        Eliminar
                    </button>
                    <button @click="closeModal"
                        class="bg-gray-200 text-gray-900 px-4 py-2 rounded-lg hover:bg-gray-300">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>




<script>
import Top from "@/assets/images/home/tt.png";

export default {
    data() {
        return {
            Top,
        };
    },
    props: {
        imageSrc: {
            type: String,
            required: false,
        },
    },
    methods: {

        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        },
    },
};
</script>
