<template>

    <Head title="Categorias" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categorias
            </h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center mb-4">
                    <a :href="route('portfolio.categories.create')"
                        class="bg-secondary-default text-white px-4 py-2 rounded shadow">
                        Adicionar Categoria
                    </a>
                </div>

                <!-- Campo de pesquisa -->
                <div class="mb-4">
                    <input v-model="search" type="text" placeholder="Pesquisar"
                        class="border border-gray-300 rounded px-4 py-2 w-full" />
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

                <!-- Mensagem de erro se não houver categorias -->
                <div v-if="!loading && filteredCategories.length === 0"
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    Não há categorias disponíveis
                </div>

                <!-- Tabela de dados com Draggable -->
                <div v-if="!loading && filteredCategories.length > 0"
                    class="overflow-x-auto bg-white shadow-md rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ordem
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nome
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>

                        <!-- DRAGGABLE -->
                        <!-- Usamos v-model="categoriesLocal" (a lista "oficial") -->
                        <!-- e :list="filteredCategories" para exibir apenas as filtradas -->
                        <Draggable tag="tbody" v-model="categoriesLocal" :list="filteredCategories" itemKey="id"
                            @end="onDragEnd" handle=".drag-handle" :disabled="loading">
                            <template #item="{ element }">
                                <tr :key="element.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="cursor-move drag-handle text-gray-500">
                                            &#x2630;
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ element.name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-4">
                                            <!-- Botão Editar -->
                                            <a :href="`/backoffice/portfolios/categories/edit/${element.id}`"
                                                class="text-primary-default flex items-center space-x-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M5 13l4 4L19 7M4 4a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                                                </svg>
                                                <span>Editar</span>
                                            </a>

                                            <!-- Botão Eliminar -->
                                            <button @click.prevent="confirmDelete(element.id)"
                                                class="text-secondary-default flex items-center space-x-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                <span>Eliminar</span>
                                            </button>

                                            <!-- Botão Arquivar/Desarquivar -->
                                            <button @click.prevent="toggleArchive(element)"
                                                :class="element.archived ? 'text-green-500' : 'text-yellow-500'"
                                                class="flex items-center space-x-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" :d="element.archived
                                                            ? 'M3 12l2-2m0 0l7-7 7 7M13 5v6h6'
                                                            : 'M12 4v16m8-8H4'" />
                                                </svg>
                                                <span>
                                                    {{ element.archived ? "Desarquivar" : "Arquivar" }}
                                                </span>
                                            </button>
                                            <!-- Botão Alternar Visibilidade no Portfólio -->
                                            <button @click.prevent="togglePortfolioVisibility(element)"
                                                :class="element.visible_on_portfolio ? 'text-purple-500' : 'text-gray-500'"
                                                class="flex items-center space-x-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" :d="element.visible_on_portfolio
                                                            ? 'M9 12l2 2l4-4'
                                                            : 'M4 6h16M4 12h16m-7 6h7'" />
                                                </svg>
                                                <span>
                                                    {{
                                                        element.visible_on_portfolio
                                                            ? "Ocultar no Portfólio"
                                                            : "Mostrar no Portfólio"
                                                    }}
                                                </span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </Draggable>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmação de Exclusão -->
        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-gray-500 bg-opacity-75 absolute inset-0"></div>
            <div class="bg-white rounded-lg shadow-lg p-6 relative z-10">
                <h3 class="text-lg font-semibold text-gray-900">
                    Eliminar Categoria
                </h3>
                <p class="mt-2 text-sm text-gray-700">
                    Tem certeza de que deseja excluir esta categoria? Esta ação
                    não pode ser desfeita.
                </p>
                <div class="mt-4 flex justify-end space-x-4">
                    <button @click="deleteCategory" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700">
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

<script setup>
import { ref, computed, onMounted } from "vue";
import { usePage, Head } from "@inertiajs/vue3";
import axios from "axios";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";
import Draggable from "vuedraggable";

const page = usePage();
const props = ref(page.props);

// === 1) ARRAY REATIVO LOCAL (onde Draggable atua) ===
const categoriesLocal = ref([]);

// === 2) OUTROS ESTADOS ===
const search = ref("");
const loading = ref(false);
const showModal = ref(false);
const categoryToDelete = ref(null);

// === 3) COPIA CATEGORIAS DAS PROPS AO MONTAR ===
onMounted(() => {
    categoriesLocal.value = props.value.categories || [];
    console.log("Current categories:", categoriesLocal.value);
});

// === 4) FILTRO SOMENTE PARA EXIBIR (não é v-model do Draggable) ===
const filteredCategories = computed(() => {
    if (!search.value.trim()) {
        return categoriesLocal.value;
    }
    return categoriesLocal.value.filter((item) =>
        item.name.toLowerCase().includes(search.value.toLowerCase())
    );
});

// === 5) EXCLUSÃO / MODAL ===
const confirmDelete = (categoryId) => {
    categoryToDelete.value = categoryId;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    categoryToDelete.value = null;
};

const deleteCategory = async () => {
    if (!categoryToDelete.value) return;
    loading.value = true;
    try {
        await axios.post("/backoffice/portfolios/categories/delete/", {
            id: categoryToDelete.value,
        });
        Toastify({
            text: "Categoria excluída com sucesso!",
            backgroundColor: "#28a745",
        }).showToast();

        // Remover localmente
        categoriesLocal.value = categoriesLocal.value.filter(
            (cat) => cat.id !== categoryToDelete.value
        );
    } catch (error) {
        Toastify({
            text: "Erro ao excluir a categoria: " + error.message,
            backgroundColor: "#dc3545",
        }).showToast();
    } finally {
        loading.value = false;
        closeModal();
    }
};

// === 6) TOGGLE ARCHIVE ===
const toggleArchive = async (category) => {
    loading.value = true;
    try {
        await axios.post(`/backoffice/portfolios/categories/${category.id}/toggle-archive`);
        category.archived = !category.archived;

        Toastify({
            text: category.archived
                ? "Categoria arquivada com sucesso!"
                : "Categoria desarquivada com sucesso!",
            backgroundColor: category.archived ? "#ffc107" : "#28a745",
        }).showToast();
    } catch (error) {
        Toastify({
            text: "Erro ao atualizar o status de arquivamento.",
            backgroundColor: "#dc3545",
        }).showToast();
    } finally {
        loading.value = false;
    }
};

// === 8) TOGGLE VISIBILITY (PORTFOLIO) ===
const togglePortfolioVisibility = async (category) => {
    loading.value = true;
    try {
        await axios.post(
            `/backoffice/portfolios/categories/${category.id}/toggle-visibility-on-portfolio`
        );
        category.visible_on_portfolio = !category.visible_on_portfolio;

        Toastify({
            text: category.visible_on_portfolio
                ? "Categoria agora visível no portfólio!"
                : "Categoria agora oculta no portfólio!",
            backgroundColor: category.visible_on_portfolio ? "#6a1b9a" : "#9e9e9e",
        }).showToast();
    } catch (error) {
        Toastify({
            text: "Erro ao atualizar a visibilidade no portfólio.",
            backgroundColor: "#dc3545",
        }).showToast();
    } finally {
        loading.value = false;
    }
};

// === 9) DRAG & DROP (onDragEnd) ===
const onDragEnd = async () => {
    // Pegamos a nova ordem de 'categoriesLocal'
    const orderedIds = categoriesLocal.value.map((cat) => cat.id);

    loading.value = true;
    try {
        // Enviar a nova ordem pro back-end
        await axios.post("/backoffice/portfolios/categories/reorder", {
            orderedIds,
        });

        Toastify({
            text: "Ordem das categorias atualizada com sucesso!",
            backgroundColor: "#28a745",
        }).showToast();
    } catch (error) {
        Toastify({
            text: "Erro ao atualizar a ordem das categorias.",
            backgroundColor: "#dc3545",
        }).showToast();
    } finally {
        loading.value = false;
    }
};
</script>
