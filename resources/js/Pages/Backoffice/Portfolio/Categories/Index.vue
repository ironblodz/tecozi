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
                    <a
                        :href="route('portfolio.categories.create')"
                        class="bg-secondary-default text-white px-4 py-2 rounded shadow"
                    >
                        Adicionar Categoria
                    </a>
                </div>

                <!-- Campo de pesquisa -->
                <div class="mb-4">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Pesquisar"
                        class="border border-gray-300 rounded px-4 py-2 w-full"
                    />
                </div>

                <!-- Loader -->
                <div v-if="loading" class="flex justify-center">
                    <div class="relative">
                        <svg
                            class="animate-spin h-8 w-8 text-blue-700"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                        >
                            <circle
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path d="M4 12a8 8 0 1 1 8 8V12h-8z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Mensagem de erro se não houver categorias -->
                <div
                    v-if="!loading && filteredCategories.length === 0"
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                >
                    Não há categorias disponíveis
                </div>

                <!-- Tabela de dados -->
                <div
                    v-if="!loading && filteredCategories.length > 0"
                    class="overflow-x-auto bg-white shadow-md rounded-lg"
                >
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Imagem
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Nome
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Subtitulo
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Descrição
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr
                                v-for="item in filteredCategories"
                                :key="item.id"
                            >
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img
                                        v-if="item.img"
                                        :src="`/storage/` + item.img"
                                        alt="Imagem da categoria"
                                        class="w-16 h-16 object-cover rounded-md"
                                    />
                                    <span v-else class="text-gray-500 italic"
                                        >Sem imagem</span
                                    >
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ item.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ item.subtitle }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                                >
                                    <div class="flex items-center space-x-4">
                                        <!-- Botão Editar -->
                                        <a
                                            :href="`/backoffice/portfolios/categories/edit/${item.id}`"
                                            class="text-primary-default flex items-center space-x-1"
                                        >
                                            <svg
                                                class="w-5 h-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M5 13l4 4L19 7M4 4a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                ></path>
                                            </svg>
                                            <span>Editar</span>
                                        </a>

                                        <!-- Botão Eliminar -->
                                        <button
                                            @click.prevent="
                                                confirmDelete(item.id)
                                            "
                                            class="text-secondary-default flex items-center space-x-1"
                                        >
                                            <svg
                                                class="w-5 h-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"
                                                ></path>
                                            </svg>
                                            <span>Eliminar</span>
                                        </button>

                                        <!-- Botão Arquivar/Desarquivar -->
                                        <button
                                            @click.prevent="toggleArchive(item)"
                                            :class="
                                                item.archived
                                                    ? 'text-green-500'
                                                    : 'text-yellow-500'
                                            "
                                            class="flex items-center space-x-1"
                                        >
                                            <svg
                                                class="w-5 h-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    :d="
                                                        item.archived
                                                            ? 'M3 12l2-2m0 0l7-7 7 7M13 5v6h6'
                                                            : 'M12 4v16m8-8H4'
                                                    "
                                                ></path>
                                            </svg>
                                            <span>{{
                                                item.archived
                                                    ? "Desarquivar"
                                                    : "Arquivar"
                                            }}</span>
                                        </button>

                                        <!-- Botão Alternar Visibilidade na Página de Materiais -->
                                        <button
                                            @click.prevent="
                                                toggleVisibility(item)
                                            "
                                            :class="
                                                item.visible_in_materials
                                                    ? 'text-blue-500'
                                                    : 'text-gray-500'
                                            "
                                            class="flex items-center space-x-1"
                                        >
                                            <svg
                                                class="w-5 h-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    :d="
                                                        item.visible_in_materials
                                                            ? 'M13 10V3L4 14h7v7l9-11h-7z'
                                                            : 'M13 10V3L4 14h7v7l9-11h-7z'
                                                    "
                                                ></path>
                                            </svg>
                                            <span>{{
                                                item.visible_in_materials
                                                    ? "Ocultar na Materiais"
                                                    : "Mostrar na Materiais"
                                            }}</span>
                                        </button>
                                        <button
                                            @click.prevent="
                                                togglePortfolioVisibility(item)
                                            "
                                            :class="
                                                item.visible_on_portfolio
                                                    ? 'text-purple-500'
                                                    : 'text-gray-500'
                                            "
                                            class="flex items-center space-x-1"
                                        >
                                            <svg
                                                class="w-5 h-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    :d="
                                                        item.visible_on_portfolio
                                                            ? 'M9 12l2 2l4-4'
                                                            : 'M4 6h16M4 12h16m-7 6h7'
                                                    "
                                                ></path>
                                            </svg>
                                            <span>{{
                                                item.visible_on_portfolio
                                                    ? "Ocultar no Portfólio"
                                                    : "Mostrar no Portfólio"
                                            }}</span>
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
        <div
            v-if="showModal"
            class="fixed inset-0 flex items-center justify-center z-50"
        >
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
                    <button
                        @click="deleteCategory"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700"
                    >
                        Eliminar
                    </button>
                    <button
                        @click="closeModal"
                        class="bg-gray-200 text-gray-900 px-4 py-2 rounded-lg hover:bg-gray-300"
                    >
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

// Página e props
const page = usePage();
const props = ref(page.props);

// Definições da tabela (se ainda não estiver sendo usado, pode ser removido)
const headers = [
    { text: "Name", value: "name", align: "center" },
    { text: "Actions", value: "actions", align: "center", sortable: false },
];

// Estado e dados
const categories = computed(() => props.value?.categories || []);
const search = ref("");
const loading = ref(false);
const showModal = ref(false);
const categoryToDelete = ref(null);

// Filtrar categorias com base na pesquisa
const filteredCategories = computed(() => {
    if (!search.value.trim()) {
        return categories.value;
    } else {
        return categories.value.filter((item) =>
            item.name.toLowerCase().includes(search.value.trim().toLowerCase())
        );
    }
});

// Confirmar exclusão
const confirmDelete = (categoryId) => {
    categoryToDelete.value = categoryId;
    showModal.value = true;
};

// Fechar modal
const closeModal = () => {
    showModal.value = false;
    categoryToDelete.value = null;
};

// Confirmar exclusão da categoria
const deleteCategory = async () => {
    if (categoryToDelete.value) {
        loading.value = true;
        try {
            await axios.post("/backoffice/portfolios/categories/delete/", {
                id: categoryToDelete.value,
            });
            console.log("Category deleted");
            Toastify({
                text: "Categoria excluída com sucesso!",
                backgroundColor: "#28a745",
                className: "info",
            }).showToast();
            // Remover a categoria excluída da lista local
            props.value.categories = props.value.categories.filter(
                (category) => category.id !== categoryToDelete.value
            );
        } catch (error) {
            console.error("Error deleting category:", error);
            Toastify({
                text: "Erro ao excluir a categoria: " + error.message,
                backgroundColor: "#dc3545",
                className: "error",
            }).showToast();
        } finally {
            loading.value = false;
            closeModal();
        }
    }
};

// Método para alternar o status de arquivamento
const toggleArchive = async (category) => {
    loading.value = true;
    try {
        await axios.post(
            `/backoffice/portfolios/categories/${category.id}/toggle-archive`
        );
        // Atualizar o status localmente
        category.archived = !category.archived;
        Toastify({
            text: category.archived
                ? "Categoria arquivada com sucesso!"
                : "Categoria desarquivada com sucesso!",
            backgroundColor: category.archived ? "#ffc107" : "#28a745",
            className: "info",
        }).showToast();
    } catch (error) {
        console.error("Erro ao alternar arquivamento:", error);
        Toastify({
            text: "Erro ao atualizar o status de arquivamento.",
            backgroundColor: "#dc3545",
            className: "error",
        }).showToast();
    } finally {
        loading.value = false;
    }
};

// Método para alternar a visibilidade na página de materiais
const toggleVisibility = async (category) => {
    loading.value = true;
    try {
        await axios.post(
            `/backoffice/portfolios/categories/${category.id}/toggle-visibility`
        );
        // Atualizar a visibilidade localmente
        category.visible_in_materials = !category.visible_in_materials;
        Toastify({
            text: category.visible_in_materials
                ? "Categoria agora visível na página de Materiais!"
                : "Categoria agora oculta na página de Materiais!",
            backgroundColor: category.visible_in_materials
                ? "#007bff"
                : "#6c757d",
            className: "info",
        }).showToast();
    } catch (error) {
        console.error("Erro ao alternar visibilidade:", error);
        Toastify({
            text: "Erro ao atualizar a visibilidade da categoria.",
            backgroundColor: "#dc3545",
            className: "error",
        }).showToast();
    } finally {
        loading.value = false;
    }
};

const togglePortfolioVisibility = async (category) => {
    loading.value = true;
    try {
        await axios.post(
            `/backoffice/portfolios/categories/${category.id}/toggle-visibility-on-portfolio`
        );
        // Atualizar a visibilidade localmente
        category.visible_on_portfolio = !category.visible_on_portfolio;
        Toastify({
            text: category.visible_on_portfolio
                ? "Categoria agora visível no portfólio!"
                : "Categoria agora oculta no portfólio!",
            backgroundColor: category.visible_on_portfolio
                ? "#6a1b9a"
                : "#9e9e9e",
            className: "info",
        }).showToast();
    } catch (error) {
        console.error("Erro ao alternar visibilidade no portfólio:", error);
        Toastify({
            text: "Erro ao atualizar a visibilidade no portfólio.",
            backgroundColor: "#dc3545",
            className: "error",
        }).showToast();
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    console.log("Current categories:", categories.value);
});
</script>
