<script setup>
import { ref, computed, onMounted } from 'vue';
import { usePage, Head } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

// Página e props
const page = usePage();
const props = ref(page.props);

// Estado e dados
const portfolios = computed(() => props.value?.portfolios || []);
const categories = ref([]); // Lista de categorias
const search = ref('');
const loading = ref(false);
const showModal = ref(false);
const portfolioToDelete = ref(null);

// Filtrar portfolios com base na pesquisa
const filteredPortfolio = computed(() => {
    if (!search.value.trim()) {
        return portfolios.value.map(portfolio => {
            const category = categories.value.find(c => c.id === portfolio.category_id);
            return { ...portfolio, category_name: category ? category.name : 'Categoria não encontrada' };
        });
    } else {
        return portfolios.value.filter(item =>
            item?.title?.toLowerCase().includes(search.value.trim().toLowerCase())
        ).map(portfolio => {
            const category = categories.value.find(c => c.id === portfolio.category_id);
            return { ...portfolio, category_name: category ? category.name : 'Categoria não encontrada' };
        });
    }
});

// Função para alternar o estado de destaque
const toggleHighlight = async (portfolioId) => {
    try {
        await axios.post('/backoffice/portfolios/toggle-highlight', { id: portfolioId });
        // Atualizar a lista local para refletir o novo estado de destaque
        const portfolio = portfolios.value.find(item => item.id === portfolioId);
        if (portfolio) {
            portfolio.highlighted = !portfolio.highlighted; // Alterna o estado de destaque
        }
        Toastify({ text: "Status atualizado com sucesso!" }).showToast();
    } catch (error) {
        Toastify({ text: `Erro: ${error.message}` }).showToast();
    }
};

// Confirmar exclusão
const confirmDelete = (portfolioId) => {
    portfolioToDelete.value = portfolioId;
    showModal.value = true;
};

// Fechar modal
const closeModal = () => {
    showModal.value = false;
    portfolioToDelete.value = null;
};

// Função para alternar o estado de arquivamento
const toggleArchive = async (portfolioId) => {
    try {
        const response = await axios.post('/backoffice/portfolios/toggle-archive', { id: portfolioId });

        // Atualizando o portfólio na lista local
        const portfolio = portfolios.value.find(item => item.id === portfolioId);
        if (portfolio) {
            portfolio.archived = !portfolio.archived; // Alterna o estado de arquivamento
        }

        Toastify({ text: response.data.message }).showToast();
    } catch (error) {
        Toastify({ text: `Erro: ${error.message}` }).showToast();
    }
};

// Remover portfólio excluído imediatamente da lista filtrada
const deletePortfolio = async () => {
    if (portfolioToDelete.value) {
        loading.value = true;
        try {
            await axios.post('/backoffice/portfolios/delete/', { id: portfolioToDelete.value });
            Toastify({ text: "Portfólio excluído com sucesso!" }).showToast();

            // Remover o portfolio da lista local de forma reativa
            props.value.portfolios = props.value.portfolios.filter(
                (portfolio) => portfolio.id !== portfolioToDelete.value
            );
        } catch (error) {
            Toastify({ text: `Erro: ${error.message}` }).showToast();
        } finally {
            loading.value = false;
            closeModal();
        }
    }
};


onMounted(() => {
    console.log('Current portfolios:', portfolios.value);
    // Buscar categorias do backend
    axios.get('/backoffice/portfolios/categories')
        .then(response => {
            // Verifique se response.data é uma array
            if (Array.isArray(response.data)) {
                categories.value = response.data;
            } else {
                console.error("A resposta não contém um array de categorias");
                categories.value = []; // Inicialize como um array vazio
            }
        })
        .catch(error => {
            console.error("Erro ao carregar categorias:", error);
            categories.value = []; // Caso haja erro, inicializa com array vazio
        });
});
</script>

<template>

    <Head title="Portfólios" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Portfólio
            </h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center mb-4">
                    <a :href="route('portfolio.create')"
                        class="bg-secondary-default text-white px-4 py-2 rounded shadow">
                        Adicionar Projeto
                    </a>
                </div>

                <!-- Campo de pesquisa -->
                <div class="mb-4">
                    <input v-model="search" type="text" placeholder="Pesquisar"
                        class="border border-gray-300 rounded px-4 py-2 w-full">
                </div>

                <!-- Loader -->
                <div v-if="loading" class="flex justify-center">
                    <div class="relative">
                        <svg class="animate-spin h-8 w-8 text-blue-700" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path d="M4 12a8 8 0 1 1 8 8V12h-8z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Mensagem de erro se não houver portfolios -->
                <div v-if="!loading && filteredPortfolio.length === 0"
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    Não há portfólios disponíveis
                </div>

                <!-- Tabela de dados -->
                <div v-if="!loading && filteredPortfolio.length > 0"
                    class="overflow-x-auto bg-white shadow-md rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Imagem
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Galeria
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Categoria
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Titulo
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Outras Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="item in filteredPortfolio" :key="item.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img :src="`/storage/` + item.main_image" alt="Imagem do Produto"
                                        class="w-16 h-16 object-cover rounded-md">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-2">
                                        <div v-for="image in item.images" :key="image.id" class="w-16 h-16">
                                            <img :src="`/storage/${image.path}`" alt="Imagem do Produto"
                                                class="object-cover w-full h-full rounded-md" />
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ item.category_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ item.title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-4">
                                        <a :href="`/backoffice/portfolios/edit/${item.id}`"
                                            class="text-primary-default flex items-center space-x-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7M4 4a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z">
                                                </path>
                                            </svg>
                                            <span>Editar</span>
                                        </a>
                                        <button @click.prevent="confirmDelete(item.id)"
                                            class="text-secondary-default flex items-center space-x-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            <span>Eliminar</span>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-4">
                                        <button @click="toggleHighlight(item.id)"
                                            :class="{ 'bg-primary-default text-white': item.highlighted, 'bg-gray-200': !item.highlighted }"
                                            class="px-4 py-2 rounded-lg">
                                            {{ item.highlighted ? 'Destacado' : 'Destacar' }}
                                        </button>
                                        <button @click="toggleArchive(item.id)"
                                            :class="{ 'bg-secondary-default text-white': item.archived, 'bg-gray-200': !item.archived }"
                                            class="px-4 py-2 rounded-lg">
                                            {{ item.archived ? 'Arquivado' : 'Arquivar' }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmação de Exclusão -->
        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-gray-500 bg-opacity-75 absolute inset-0"></div>
            <div class="bg-white rounded-lg shadow-lg p-6 relative z-10">
                <h3 class="text-lg font-semibold text-gray-900">Eliminar Portfólio</h3>
                <p class="mt-2 text-sm text-gray-700">
                    Tem certeza de que deseja excluir este portfólio? Esta ação não pode ser desfeita.</p>
                <div class="mt-4 flex justify-end space-x-4">
                    <button @click="deletePortfolio"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700">Eliminar</button>
                    <button @click="closeModal"
                        class="bg-gray-200 text-gray-900 px-4 py-2 rounded-lg hover:bg-gray-300">Cancelar</button>
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
            required: true,
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
